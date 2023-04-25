<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for editing remote_content block instances.
 *
 * @package   local_alternatelogin
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define('AJAX_SCRIPT', true);

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
    exit(0);
}

if ($action == 'checkcode') {
    $authcode = required_param('code', PARAM_TEXT);
    $config = get_config('local_alternatelogin');
    $result = new StdClass;
    $result->what = 'checkcode';
    $result->result = 0;
    if (!empty($config->signupcode) && ($config->signupcode == $authcode)) {
        $result->result = 1;
    }

    echo json_encode($result);
    exit(0);
}
