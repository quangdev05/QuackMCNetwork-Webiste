<?php
require_once(__DIR__ . "/../config/db.php");

$ptdung = new PTDUNG();

$rcon_host = $ptdung->site('host_rcon');
$rcon_port = $ptdung->site('port_rcon');
$rcon_password = $ptdung->site('pass_rcon');
$discord_webhook_url = $ptdung->site('discord_webhook_recharge_bank');
$timeout_rcon = (int)$ptdung->site('timeout_rcon');
$api_key = $ptdung->site('api_sepay');

$headers = apache_request_headers();
$authorization = isset($headers['Authorization']) ? $headers['Authorization'] : '';
if (empty($authorization) || $authorization !== 'Apikey ' . $api_key) {
    writeLog("Invalid API key");
    http_response_code(403);
    echo json_encode(["status" => false, "msg" => "Invalid API key"]);
    exit;
}

if (!$rcon_host || !$rcon_port || !$rcon_password || !$discord_webhook_url) {
    writeLog("Missing configuration values from database.");
    http_response_code(500);
    echo json_encode(["status" => false, "msg" => "Missing configuration values"]);
    exit;
}

function writeLog($message)
{
    $logFile = 'game-recharge-bank_log.txt';
    $date = date('H:i:s | Y/m/d');
    file_put_contents($logFile, "[$date] $message" . PHP_EOL, FILE_APPEND);
}

class Rcon
{
    private $host;
    private $port;
    private $password;
    private $timeout;
    private $socket;
    private $authorized;
    private $last_response;

    const PACKET_AUTHORIZE = 5;
    const PACKET_COMMAND = 6;

    const SERVERDATA_AUTH = 3;
    const SERVERDATA_AUTH_RESPONSE = 2;
    const SERVERDATA_EXECCOMMAND = 2;
    const SERVERDATA_RESPONSE_VALUE = 0;

    public function __construct($host, $port, $password, $timeout)
    {
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;
        $this->timeout = $timeout;
    }

    public function get_response()
    {
        return $this->last_response;
    }

    public function connect()
    {
        $this->socket = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);

        if (!$this->socket) {
            $this->last_response = $errstr;
            return false;
        }

        stream_set_timeout($this->socket, 3, 0);

        $auth = $this->authorize();

        return $auth;
    }

    public function disconnect()
    {
        if ($this->socket) {
            fclose($this->socket);
        }
    }

    public function is_connected()
    {
        return $this->authorized;
    }

    public function send_command($command)
    {
        if (!$this->is_connected()) {
            return false;
        }

        $this->write_packet(Rcon::PACKET_COMMAND, Rcon::SERVERDATA_EXECCOMMAND, $command);

        $response_packet = $this->read_packet();
        if ($response_packet['id'] == Rcon::PACKET_COMMAND) {
            if ($response_packet['type'] == Rcon::SERVERDATA_RESPONSE_VALUE) {
                $this->last_response = $response_packet['body'];
                return $response_packet['body'];
            }
        }

        return false;
    }

    private function authorize()
    {
        $this->write_packet(Rcon::PACKET_AUTHORIZE, Rcon::SERVERDATA_AUTH, $this->password);
        $response_packet = $this->read_packet();

        if ($response_packet['type'] == Rcon::SERVERDATA_AUTH_RESPONSE) {
            if ($response_packet['id'] == Rcon::PACKET_AUTHORIZE) {
                $this->authorized = true;
                return true;
            }
        }

        $this->disconnect();
        return false;
    }

    private function write_packet($packet_id, $packet_type, $packet_body)
    {
        $packet = pack("VV", $packet_id, $packet_type);
        $packet = $packet . $packet_body . "\x00";
        $packet = $packet . "\x00";

        $packet_size = strlen($packet);

        $packet = pack("V", $packet_size) . $packet;

        fwrite($this->socket, $packet, strlen($packet));
    }

    private function read_packet()
    {
        $size_data = fread($this->socket, 4);
        $size_pack = unpack("V1size", $size_data);
        $size = $size_pack['size'];

        $packet_data = fread($this->socket, $size);
        $packet_pack = unpack("V1id/V1type/a*body", $packet_data);

        return $packet_pack;
    }
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
    writeLog("Failed to parse JSON input");
    http_response_code(400);
    echo json_encode(["status" => false, "msg" => "Invalid JSON data"]);
    exit;
}

if (!isset($input['id']) || !isset($input['content']) || !isset($input['transferAmount'])) {
    writeLog("Invalid webhook data: Missing required fields");
    http_response_code(400);
    echo json_encode(["status" => false, "msg" => "Invalid webhook data"]);
    exit;
}

$id = $input['id'];
$content = $input['content'];
$transferAmount = $input['transferAmount'];

preg_match('/PlayST\s+([^\s]+)Player/', $content, $matches);
$username = isset($matches[1]) ? $matches[1] : 'Không xác định';
$gems = floor($transferAmount / 820);
$nd = $id;

if ($username === 'Không xác định') {
    $status = "Thất bại";
    writeLog("Failed to determine username");
} else {
    $rcon = new Rcon($rcon_host, $rcon_port, $rcon_password, $timeout_rcon);
    if ($rcon->connect()) {
        $rcon_command = "dotman manual $username $transferAmount -p $gems -d $nd -f";
        $rcon_success = $rcon->send_command($rcon_command);
        $status = $rcon_success ? "Thành công" : "Thất bại";
        writeLog("RCON command result: " . $rcon->get_response());
        $rcon->disconnect();
    } else {
        $status = "Thất bại";
        writeLog("Failed to connect to RCON");
    }
}

writeLog("Transaction status: $status");

$formatted_transferAmount = number_format($transferAmount, 0, '.', '.') . 'đ';

$discord_message = [
    "embeds" => [
        [
            "fields" => [
                ["name" => "**ID đơn nạp:**", "value" => $id],
                ["name" => "**Tên nhân vật:**", "value" => $username],
                ["name" => "**Số tiền:**", "value" => $formatted_transferAmount],
                ["name" => "**Số Gems:**", "value" => $gems],
                ["name" => "**Trạng thái:**", "value" => $status],
            ]
        ]
    ]
];

$options = [
    'http' => [
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode($discord_message)
    ]
];

$context = stream_context_create($options);
$discord_response = file_get_contents($discord_webhook_url, false, $context);

if ($discord_response === false) {
    $error = error_get_last();
    writeLog("Failed to send Discord message: " . $error['message']);
} else {
    writeLog("Discord message sent successfully");
}

http_response_code(200);
echo json_encode(["status" => true, "msg" => "OK"]);
writeLog("Response sent: {\"status\":true,\"msg\":\"OK\"}");
?>