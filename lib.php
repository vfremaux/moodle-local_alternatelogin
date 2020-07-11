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
 * @package   local_alternatelogin
 * @copyright 2018 onwards Valery Fremaux <valery.fremaux@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

function local_alternatelogin_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload) {

    $fileareas = array('rendererimages');
    if (!in_array($filearea, $fileareas)) {
        return false;
    }

    $context = context_system::instance();

    $pageid = (int) array_shift($args);

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/local_alternatelogin/$filearea/$pageid/$relativepath";
    if ((!$file = $fs->get_file_by_hash(sha1($fullpath))) || $file->is_directory()) {
        return false;
    }

    // Finally send the file.
    send_stored_file($file, 0, 0, true); // Download MUST be forced - security!
}

function local_alternatelogin_pluginfile_url($filename) {
    $path = dirname($filename);
    $filename = basename($filename);

    $systemcontext = context_system::instance();
    return moodle_url::make_pluginfile_url($systemcontext->id, 'local_alternatelogin', 'rendererimages', 0, $path, $filename);
}

function local_alternatelogin_guess_username(&$frm) {
    global $DB;
    static $index;

    $params = local_alternatelogin_normalize($frm);

    $oldrec = $DB->get_record('user', $params);
    if ($oldrec) {
        return false;
    }

    $username = core_text::strtolower($frm->firstname).'.'.core_text::strtolower($frm->lastname);
    $indexedusername = $username.$index;

    while ($DB->record_exists('user', array('username' => $indexedusername))) {
        $index = ($index == '') ? 1 : $index++;
        $indexedusername = $username.$index;
    }

    return $indexedusername;
}

/**
 * Send email to specified user with confirmation text and activation link.
 *
 * @param stdClass $user A {@link $USER} object
 * @return bool Returns true if mail was sent OK and false if there was an error.
 */
function local_alternatelogin_send_confirmation_email($user) {
    global $CFG, $DB;

    // Get full user data.
    $user = $DB->get_record('user', array('id' => $user->id));

    $site = get_site();
    $supportuser = core_user::get_support_user();

    $data = new stdClass();
    $data->firstname = fullname($user);
    $data->sitename  = format_string($site->fullname);
    $data->admin     = generate_email_signoff();

    $subject = get_string('emailconfirmationsubject', 'local_alternatelogin', format_string($site->fullname));

    $username = urlencode($user->username);
    $username = str_replace('.', '%2E', $username); // Prevent problems with trailing dots.
    $data->link  = $CFG->wwwroot .'/local/alternatelogin/confirm.php?data='. $user->secret .'/'. $username;
    $data->link .= "&wantsurl=/my/index.php";
    $message     = get_string('emailconfirmation', 'local_alternatelogin', $data);
    $messagehtml = text_to_html(get_string('emailconfirmation', 'local_alternatelogin', $data), false, false, true);

    $user->mailformat = 1;  // Always send HTML version as well.

    // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
    return email_to_user($user, $supportuser, $subject, $message, $messagehtml);
}

function local_alternatelogin_validate($user) {
    global $DB, $SESSION;

    $config = get_config('local_alternatelogin');

    $errors = false;

    if (empty($user->email)) {
        $errors['email'] = get_string('errorempty', 'local_alternatelogin');
    }

    if (!empty($config->accepteddomains)) {
        $domainlist = explode(',', $config->accepteddomains);
        $pass = false;
        foreach ($domainlist as $domain) {
            $domain = trim($domain);
            if (preg_match('/'.$domain.'$/', $user->email)) {
                $pass = true;
                break;
            }
        }

        if ($pass == false) {
            $errors['email'] = get_string('errornotinvaliddomains', 'local_alternatelogin');
        }
    }

    if (empty($user->firstname)) {
        $errors['firstname'] = get_string('errorempty', 'local_alternatelogin');
    }

    if (empty($user->lastname)) {
        $errors['lastname'] = get_string('errorempty', 'local_alternatelogin');
    }

    if (empty($user->password)) {
        $errors['password'] = get_string('errorempty', 'local_alternatelogin');
    }

    if (!empty($user->password) && ($user->password != $user->passwordconfirm)) {
        $errors['password'] = get_string('errornomatch', 'local_alternatelogin');
        $errors['passwordconfirm'] = get_string('errornomatch', 'local_alternatelogin');
    }

    if (!check_password_policy($user->password, $errmsg)) {
        $errors['password'] = get_string('errorpasswordpolicy', 'local_alternatelogin');
    }

    if (!empty($user->email)) {

        if (!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/', $user->email)) {
            $errors['email'] = get_string('errormalformed', 'local_alternatelogin');
        } else {


            if ($user->email != $user->emailconfirm) {
                $errors['email'] = get_string('errornomatch', 'local_alternatelogin');
                $errors['emailconfirm'] = get_string('errornomatch', 'local_alternatelogin');
            }

            if ($DB->get_record('user', array('username' => $user->email, 'deleted' => 0))) {
                $errors['email'] = get_string('errorexists', 'local_alternatelogin');
            } else if ($DB->get_record('user', array('email' => $user->email, 'deleted' => 0))) {
                $errors['email'] = get_string('errorexistsinternal', 'local_alternatelogin');
            }
        }
    }

    if ($config->withcapcha) {
        if ($user->capcha != $SESSION->alternatelogin->capcha->checkchar) {
            $errors['capcha'] = get_string('errorcapchacheck', 'local_alternatelogin');
            $errors['globals'] = get_string('errorcapchacheck', 'local_alternatelogin');
        }
    }

    return $errors;
}