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
 * External database log store settings.
 *
 * @package    local_alternatelogin
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_alternatelogin', get_string('pluginname', 'local_alternatelogin'));

    $loginlink = new moodle_url('/local/alternatelogin/login.php');
    $help = get_string('alternatelogin_help', 'local_alternatelogin', ''.$loginlink);
    $settings->add(new admin_setting_heading('alternatelogin', get_string('alternatelogin', 'local_alternatelogin'), $help));

    $key = 'local_alternatelogin/enabled';
    $label = get_string('configenabled', 'local_alternatelogin');
    $desc = get_string('configenabled_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, 1));

    $key = 'local_alternatelogin/signupcode';
    $label = get_string('configsignupcode', 'local_alternatelogin');
    $desc = get_string('configsignupcode_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_configtext($key, $label, $desc, $default));

    $key = 'local_alternatelogin/welcometext';
    $label = get_string('configwelcometext', 'local_alternatelogin');
    $desc = get_string('configwelcometext_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_confightmleditor($key, $label, $desc, $default));

    $key = 'local_alternatelogin/modaltitle';
    $label = get_string('configmodaltitle', 'local_alternatelogin');
    $desc = get_string('configmodaltitle_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_configtext($key, $label, $desc, $default));

    $key = 'local_alternatelogin/modalinfo';
    $label = get_string('configmodalinfo', 'local_alternatelogin');
    $desc = get_string('configmodalinfo_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_confightmleditor($key, $label, $desc, $default));

    $key = 'local_alternatelogin/signuptext';
    $label = get_string('configsignuptext', 'local_alternatelogin');
    $desc = get_string('configsignuptext_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_confightmleditor($key, $label, $desc, $default));

    /*
    $key = 'local_alternatelogin/extra1text';
    $label = get_string('configextra1text', 'local_alternatelogin');
    $desc = get_string('configextra1text_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_confightmleditor($key, $label, $desc, $default));

    $key = 'local_alternatelogin/extra2text';
    $label = get_string('configextra2text', 'local_alternatelogin');
    $desc = get_string('configextra2text_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_confightmleditor($key, $label, $desc, $default));

    $key = 'local_alternatelogin/extra3text';
    $label = get_string('configextra3text', 'local_alternatelogin');
    $desc = get_string('configextra3text_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_confightmleditor($key, $label, $desc, $default));

    $key = 'local_alternatelogin/extra4text';
    $label = get_string('configextra4text', 'local_alternatelogin');
    $desc = get_string('configextra4text_desc', 'local_alternatelogin');
    $default = '';
    $settings->add(new admin_setting_confightmleditor($key, $label, $desc, $default));
    */

    $key = 'local_alternatelogin/loginusesmail';
    $label = get_string('configloginusesmail', 'local_alternatelogin');
    $desc = get_string('configloginusesmail_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, 0));

    $select = " datatype = 'menu' OR datatype = 'text' OR datatype = 'textarea' ";
    $fields = $DB->get_records_select_menu('user_info_field', $select, [], 'id,name');
    $fields = ['' => get_string('unset', 'local_alternatelogin')] + $fields;

    $key = 'local_alternatelogin/civilityfieldid';
    $label = get_string('configcivilityfield', 'local_alternatelogin');
    $desc = get_string('configcivilityfield_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configselect($key, $label, $desc, 'alternateprofile', $fields));

    if (!empty($fields)) {
        for ($i = 0; $i < 3; $i++) {
            $key = 'local_alternatelogin/profilefield'.$i;
            $label = get_string('configprofilefield', 'local_alternatelogin')." $i";
            $desc = get_string('configprofilefield_desc', 'local_alternatelogin');
            $settings->add(new admin_setting_configselect($key, $label, $desc, 'alternateprofile', $fields));
        }
    }

    $key = 'local_alternatelogin/resultingauthmethod';
    $label = get_string('configresultingauthmethod', 'local_alternatelogin');
    $desc = get_string('configresultingauthmethod_desc', 'local_alternatelogin');
    $fields = $DB->get_records_menu('user_info_field', array('datatype' => 'menu'), 'name');
    $options = get_enabled_auth_plugins();
    if ($options) {
        foreach ($options as $authopt) {
            $authoptions[$authopt] = get_string('pluginname', 'auth_'.$authopt);
        }
        $settings->add(new admin_setting_configselect($key, $label, $desc, 'email', $authoptions));
    }

    $key = 'local_alternatelogin/accepteddomains';
    $label = get_string('configaccepteddomains', 'local_alternatelogin');
    $desc = get_string('configaccepteddomains_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configtext($key, $label, $desc, ''));

    $settings->add(new admin_setting_heading('alternatelogin_apparearance', get_string('appearance', 'local_alternatelogin'), ''));

    $key = 'local_alternatelogin/rendererimages';
    $label = get_string('configrendererimages', 'local_alternatelogin');
    $desc = get_string('configrendererimages_desc', 'local_alternatelogin');
    $options = array('subdirs' => false, 'maxfiles' => 20);
    $settings->add(new admin_setting_configstoredfile($key, $label, $desc, 'rendererimages', 0, $options));

    $key = 'local_alternatelogin/extracss';
    $label = get_string('configextracss', 'local_alternatelogin');
    $desc = get_string('configextracss_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configtextarea($key, $label, $desc, ''));

    $key = 'local_alternatelogin/stylesheets';
    $label = get_string('configstylesheets', 'local_alternatelogin');
    $desc = get_string('configstylesheets_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configtext($key, $label, $desc, ''));

    $key = 'local_alternatelogin/noheader';
    $label = get_string('confignoheader', 'local_alternatelogin');
    $desc = get_string('confignoheader_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, 1));

    $key = 'local_alternatelogin/nofooter';
    $label = get_string('confignofooter', 'local_alternatelogin');
    $desc = get_string('confignofooter_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, 1));

    $key = 'local_alternatelogin/withcapcha';
    $label = get_string('configwithcapcha', 'local_alternatelogin');
    $desc = get_string('configwithcapcha_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, 1));

    $key = 'local_alternatelogin/withcountry';
    $label = get_string('configwithcountry', 'local_alternatelogin');
    $desc = get_string('configwithcountry_desc', 'local_alternatelogin');
    $settings->add(new admin_setting_configcheckbox($key, $label, $desc, 1));

    $ADMIN->add('localplugins', $settings);
}