<?php
require_once(__DIR__ . "/../config/db.php");
require_once(__DIR__ . "/../includes/helpers.php");

if (isset($_GET["status"])) {
    $status = $_GET["status"];
    $serial = $_GET["serial"];
    $code = $_GET["code"];
    $request_id = $_GET["request_id"];
    $message = $_GET["message"];
    $real_money = $_GET["value"];
    $geted_money = $_GET["amount"];
    $nhamang = $_GET["telco"];
    $trans_id = $_GET["trans_id"];

    $row = $PTDUNG->get_row(
        "SELECT * FROM `recharge_logs` WHERE `trans_id` = '$request_id' AND `status` = '0'"
    );
    if (!$row) {
        die("Lỗi Callback");
    }
    $row_user = $PTDUNG->get_row("SELECT * FROM `authme` WHERE `id` = '" . $row['user_id'] . "'");
    if ($status == 1) {
        $PTDUNG->update(
            "recharge_logs",
            [
                "status" => "1",
            ],
            " `id` = '" . $row["id"] . "' "
        );
        rcon_nap($row_user['realname'], $real_money);
    } else {
        $PTDUNG->update(
            "recharge_logs",
            [
                "status" => "2",
            ],
            " `id` = '" . $row["id"] . "' "
        );
    }
} else {
    die(
        json_encode([
            "status" => "error",
            "msg" => "Callback không xác định!",
        ])
    );
}
?>