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
require_once('../../config.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/local/alternatelogin/classes/auth_email_alternate.class.php');
require_once($CFG->dirroot.'/local/alternatelogin/lib.php');

$config = get_config('local_alternatelogin');

$url = new moodle_url('/local/alternatelogin/signup.php');
$PAGE->set_url($url);
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->requires->js_call_amd('local_alternatelogin/alternatelogin', 'init');
$PAGE->requires->css('/local/alternatelogin/styles.css');
if (!empty($config->stylesheets)) {
    $sheets = explode(',', $config->stylesheets);
    foreach ($sheets as $sh) {
        $PAGE->requires->css('/theme/'.$PAGE->theme->name.'/style/'.$sh.'.css');
    }
}

$renderer = $PAGE->get_renderer('local_alternatelogin');

if (optional_param('testdeadend', false, PARAM_BOOL) && ($CFG->debug == DEBUG_DEVELOPER)) {
    // A test sequence to see dead end message for tuning.
    $user = new Stdclass;
    $user->email = "sample@foo.com";
    if (empty($config->noheader)) {
        $PAGE->set_pagelayout('login');
        echo $OUTPUT->header();
    } else {
        $PAGE->set_pagelayout('embedded');
        echo $PAGE->requires->get_head_code($PAGE, $OUTPUT);
        echo $PAGE->requires->get_top_of_body_code($renderer);
    }
    echo $renderer->render_deadend($user);
    if (empty($config->nofooter)) {
        echo $OUTPUT->footer();
    }
    die;
}

$frm = data_submitted();
$errors = array();

if (!empty($frm)) {

    if (!$errors = local_alternatelogin_validate($frm)) {
        // Create user and ask moodle to generate and sent password.

        $user = clone($frm);

        $user->username = $frm->email;
        $user->confirmed = false;

        /*
        // User_signup does hashing.
        $user->password = hash_internal_user_password($frm->password);
        $user->passwordconfirm = hash_internal_user_password($frm->password);
        */
        $user->mnethostid = $CFG->mnet_localhost_id;

        $authclass = new auth_plugin_email_alternate();
        $authclass->user_signup($user, false);
        if (!empty($user->id)) {
            if (empty($config->noheader)) {
                $PAGE->set_pagelayout('login');
                echo $OUTPUT->header();
            } else {
                $PAGE->set_pagelayout('embedded');
                echo $PAGE->requires->get_head_code($PAGE, $OUTPUT);
                echo $PAGE->requires->get_top_of_body_code($renderer);
            }
            echo $renderer->render_deadend($user);
            if (empty($config->nofooter)) {
                echo $OUTPUT->footer();
            }
            die;
        } else {
            $errors['username'] = get_string('existingaccount', 'local_alternatelogin');
        }
    }
} else {
    $frm = new Stdclass;
    $frm->country = $CFG->country;
}

if (empty($config->noheader)) {
    $PAGE->set_pagelayout('login');
    echo $OUTPUT->header();
} else {
    $PAGE->set_pagelayout('embedded');
    echo $PAGE->requires->get_head_code($PAGE, $OUTPUT);
    echo $PAGE->requires->get_top_of_body_code($renderer);
}

// React to some errors : 
if (!empty($errors['password'])) {
    $frm->passwordconfirm = '';
}

if (!empty($errors['email'])) {
    $frm->emailconfirm = '';
}

$frm->confirmed = 0;

echo $renderer->render_signup_form($frm, $errors);

if (empty($config->nofooter)) {
    echo $OUTPUT->footer();
} else {
    echo $PAGE->requires->get_end_code();
}
