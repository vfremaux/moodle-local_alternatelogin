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
require_once($CFG->dirroot.'/local/alternatelogin/lib.php');

class local_alternatelogin_renderer extends plugin_renderer_base {

    public function render_login_form() {
        global $OUTPUT, $SESSION;

        $template = new StdClass;

        $config = get_config('local_alternatelogin');

        /*
        $template->extra1text = format_text(@$config->extra1text, FORMAT_MOODLE);
        $template->extra2text = format_text(@$config->extra2text, FORMAT_MOODLE);
        $template->extra3text = format_text(@$config->extra3text, FORMAT_MOODLE);
        $template->extra4text = format_text(@$config->extra4text, FORMAT_MOODLE);
        */
        $template->signuptext = format_text(@$config->signuptext, FORMAT_MOODLE, array('para' => false));
        $template->loginusesmail = !empty($config->loginusesmail);
        if ($template->loginusesmail) {
             $template->loginstr = get_string('email', 'local_alternatelogin');
        } else {
             $template->loginstr = get_string('login', 'local_alternatelogin');
        }

        if (!empty($config->extracss)) {
            while (preg_match('/(.*?)\{\{#pluginfile\}\}([^{]*?)\{\{\/pluginfile\}\}(.*)/s', $config->extracss, $matches)) {
                $config->extracss = $matches[1].local_alternatelogin_pluginfile_url($matches[2]).$matches[3];
            }

            $template->extracss = $config->extracss;
        }
        $cleanedcontent = trim(strip_tags(@$config->welcometext));
        if (!empty($cleanedcontent)) {
            $options = ['para' => false, 'noclean' => true];
            $template->welcometext = format_text($config->welcometext, FORMAT_MOODLE, $options);
        }

        if (!empty($config->noheader)) {
            $template->custommenu = $this->output->custom_menu('');
        }

        $template->forgotpassurl = new moodle_url('/login/forgot_password.php');

        $template->error = optional_param('errorcode', '', PARAM_INT);
        if ($template->error) {
            if ($template->error > 5 || !is_numeric($template->error)) {
                $error = 99;
            }
            $a = new StdClass;
            $a->error = $template->error;
            $template->errornotification = $this->output->notification(get_string('loginerror'.$template->error, 'local_alternatelogin', $a));
            unset($SESSION);
        }

        $template->loginindexurl = new moodle_url('/login/index.php');

        return $this->output->render_from_template('local_alternatelogin/login', $template);
    }

    public function render_signup_form($frm = array(), $errors = array()) {
        global $DB, $CFG, $SESSION, $OUTPUT;

        $template = (object) $frm;

        $config = get_config('local_alternatelogin');

        $template->extra1text = format_text(@$config->extra1text, FORMAT_MOODLE);
        $template->extra2text = format_text(@$config->extra2text, FORMAT_MOODLE);
        $template->extra3text = format_text(@$config->extra3text, FORMAT_MOODLE);
        $template->extra4text = format_text(@$config->extra4text, FORMAT_MOODLE);

        if (!empty($config->extracss)) {
            while (preg_match('/(.*?)\{\{#pluginfile\}\}([^{]*?)\{\{\/pluginfile\}\}(.*)/s', $config->extracss, $matches)) {
                $config->extracss = $matches[1].local_alternatelogin_pluginfile_url($matches[2]).$matches[3];
            }

            $template->extracss = $config->extracss;
        }

        // At the moment only setup for one profile field.
        // TODO : extend.

        $template->defaultauth = $config->resultingauthmethod;
        if (!empty($config->profilefield)) {
            $template->profilefield = true;
            $profilevalues = $DB->get_field('user_info_field', 'param1', array('id' => $config->profilefield));
            $template->profilefieldkey = 'profile_field_';
            $params = array('id' => $config->profilefield);
            $template->profilefieldkey .= core_text::strtolower($DB->get_field('user_info_field', 'shortname', $params));
            $profilevalues = explode("\n", $profilevalues);

            $profilefieldkey = $template->profilefieldkey;

            $i = 1;
            $j = 1;
            $template->i = $i;

            if (empty($frm->$profilefieldkey)) {
                $template->step3disabled = 'disabled="disabled"';
            }

            $haschecked = false;

            foreach ($profilevalues as $pv) {
                if (!empty(trim($pv))) {
                    $profilevaluetpl = new StdClass;
                    $profilevaluetpl->datavalue = $pv;
                    $profilevaluetpl->j = $j;
                    if (isset($frm->$profilefieldkey)  && ($frm->$profilefieldkey == $pv)) {
                        $profilevaluetpl->selectedclass = 'selected';
                        $haschecked = true;
                        $profilevaluetpl->value = $pv;
                    } else {
                        $profilevaluetpl->selectedclass = '';
                        $profilevaluetpl->value = '';
                    }
                    $profilevaluetpl->label = format_string($pv);
                    $template->profilevalue[] = $profilevaluetpl;
                }
                $j++;
            }

            if ($haschecked) {
                $template->profileunchecked = '';
            } else {
                $template->profileunchecked = 'unchecked';
            }
        }

        if (!empty($config->noheader)) {
            $template->custommenu = $OUTPUT->custom_menu('');
        }

        if (isset($frm->country)) {
            $country = $frm->country;
        } else {
            $country = $CFG->country;
        }

        $attrs = array('class' => 'field-non-empty-input unchecked');
        $template->countryselect = html_writer::select(get_string_manager()->get_list_of_countries(), 'country', $country, array('' => 'choosedots'), $attrs);
        $template->passwordpolicy = print_password_policy();

        // Processing errors.
        foreach ($errors as $errorkey => $errormsg) {
            $errorclasskey = 'error'.$errorkey.'class';
            $template->$errorclasskey = "error";
            $errormsgkey = 'error'.$errorkey;
            $template->$errormsgkey = $errormsg;
        }

        // Setup capcha.
        if (!empty($config->withcapcha)) {
            $SESSION->alternatelogin = new StdClass();
            $captcharec = new StdClass();
            $captcharec->length = 6;
            $SESSION->alternatelogin->capcha = $captcharec; // TODO parametrize this from global settings.
            $generatorurl = new moodle_url('/local/alternatelogin/print_captcha.php');
            $template->generatorurl = $generatorurl;
            $template->withcapcha = true;
        }

        $template->signupurl = new moodle_url('/local/alternatelogin/signup.php');

        return $this->output->render_from_template('local_alternatelogin/signup', $template);
    }

    function render_deadend($user) {
        $template = new StdClass;

        $config = get_config('local_alternatelogin');

        if (!empty($config->extracss)) {
            while (preg_match('/(.*?)\{\{#pluginfile\}\}([^{]*?)\{\{\/pluginfile\}\}(.*)/s', $config->extracss, $matches)) {
                $config->extracss = $matches[1].local_alternatelogin_pluginfile_url($matches[2]).$matches[3];
            }

            $template->extracss = $config->extracss;
        }
        $template->usermail = $user->email;

        return $this->output->render_from_template('local_alternatelogin/deadend', $template);
    }

    public function render_modal_info() {

        $config = get_config('local_alternatelogin');

        $template = new StdClass;

        $template->modaltitle = format_string($config->modaltitle);
        $template->modalinfo = format_text($config->modalinfo, FORMAT_MOODLE);

        return $this->output->render_from_template('local_alternatelogin/modal_info', $template);
    }

}
