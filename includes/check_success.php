<?php
require_once(__DIR__ . "/../config/db.php");
require_once(__DIR__ . "/helpers.php");

if (!isset($_GET['token'])) {
    header('Location: /free-gems/');
}

if ($row = $PTDUNG->get_row("SELECT * FROM `link_logs` WHERE `token` = '" . $_GET['token'] . "' AND `used` = 0")) {
    $user_id = $row['user_id'];
    $row1 = $PTDUNG->get_row("SELECT * FROM `freegems_info` WHERE `user_id` = '" . $user_id . "' ");
    $count = $row1['count'];
    if ($row1['count'] >= 10) {
        $count = $count - 10;
        $PTDUNG->update("freegems_info", [
            'count' => $count,
            'turns' => $row1['turns'] + 1
        ], " `user_id` = '" . $user_id . "' ");
    }
    $PTDUNG->update("freegems_info", [
        'count' => $count + 1,
        'total' => $row1['total'] + 1
    ], " `user_id` = '" . $user_id . "' ");

    $PTDUNG->update("link_logs", [
        'used' => 1
    ], " `token` = '" . $_GET['token'] . "' ");
}

header('Location: /free-gems/');