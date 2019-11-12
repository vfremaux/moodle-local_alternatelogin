<?php

require('../../../config.php');

define('AJAX_SCRIPT', true);

$action = required_param('what', PARAM_TEXT);

if ($action == 'checkpolicy') {
    $password = required_param('password', PARAM_TEXT);

    $result = new StdClass;

    if (!check_password_policy($user->password, $errmsg)) {
        $result->status = 0;
        $result->error = $errmsg;
    } else {
        $result->status = 1;
    }

    echo json_encode($result);
}