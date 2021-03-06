<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/auth/email/auth.php');

/**
 * Email authentication plugin.
 */
class auth_plugin_email_alternate extends auth_plugin_email {
    /**
     * Sign up a new user ready for confirmation.
     * Password is passed in plaintext.
     *
     * @param object $user new user object
     * @param boolean $notify print notice with link and terminate
     */
    function user_signup($user, $notify=true) {
        global $CFG, $DB;

        $config = get_config('local_alternatelogin');

        require_once($CFG->dirroot.'/user/profile/lib.php');
        require_once($CFG->dirroot.'/user/lib.php');

        $plainpassword = $user->password;
        $user->password = hash_internal_user_password($user->password);
        if (empty($user->calendartype)) {
            $user->calendartype = $CFG->calendartype;
        }

        $user->id = user_create_user($user, false, false);

        user_add_password_history($user->id, $plainpassword);

        // Save any custom profile field required by alternate login
        $field = $DB->get_record('user_info_field', array('id' => $config->profilefield));
        if (!empty($field)) {
            $profilefieldkey = 'profile_field_'.core_text::strtolower($field->shortname);
            if (!empty($user->$profilefieldkey)) {
                $inforecord = new StdClass;
                $inforecord->fieldid = $field->id;
                $inforecord->userid = $user->id;
                $inforecord->data = $user->$profilefieldkey;
                $DB->insert_record('user_info_data', $inforecord);
            }
        }

        // Trigger event.
        \core\event\user_created::create_from_userid($user->id)->trigger();

        if (! local_alternatelogin_send_confirmation_email($user)) {
            if ($CFG->debug == DEBUG_DEVELOPER) {
                print_error('auth_emailnoemail', 'auth_email');
            }
        }

        if ($notify) {
            global $CFG, $PAGE, $OUTPUT;
            $emailconfirm = get_string('emailconfirm');
            $PAGE->navbar->add($emailconfirm);
            $PAGE->set_title($emailconfirm);
            $PAGE->set_heading($PAGE->course->fullname);
            echo $OUTPUT->header();
            echo $OUTPUT->notification(get_string('emailconfirmsent', '', $user->email), "$CFG->wwwroot/index.php");
        }
        return $user->id;
    }
}