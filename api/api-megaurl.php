<?php
require_once(__DIR__ . "/../config/db.php");
require_once(__DIR__ . "/../includes/helpers.php");

// Khởi tạo đối tượng kết nối cơ sở dữ liệu
$ptdung = new PTDUNG();

$user_id = xss($_POST['id']);

if ($row = $PTDUNG->get_row('SELECT * FROM `link_logs` WHERE `user_id` = "' . $user_id . '" AND `create_time` = "' . get_date() . '" AND `used` = 0')) {
    $token = $row['token'];
} else {
    $token = bin2hex(random_bytes(16));
    $PTDUNG->insert("link_logs", array(
        'user_id' => $user_id,
        'token' => $token,
        'used' => 0,
        'create_time' => get_date()
    ));
}

$api_token = $ptdung->site('api_link');
$long_url = urlencode($_SERVER['HTTP_HOST'] . '/includes/check_success.php?token=' . $token);
$api_url = curl_get("https://megaurl.in/api?api={$api_token}&url={$long_url}");
$result = json_decode($api_url, true);
$data = "<div class='flex flex-row gap-2 user-info'><div class='font-medium'>Link:</div><div>" . $result['shortenedUrl'] . "</div></div>";
return die($data);
?>