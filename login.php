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

$config = get_config('local_alternatelogin');

$url = new moodle_url('/local/alternatelogin/login.php');
$PAGE->set_url($url);
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->requires->css('/local/alternatelogin/styles.css');
if (!empty($config->stylesheets)) {
    $sheets = explode(',', $config->stylesheets);
    foreach ($sheets as $sh) {
        $PAGE->requires->css('/theme/'.$PAGE->theme->name.'/style/'.$sh.'.css');
    }
}
$PAGE->requires->js_call_amd('local_alternatelogin/modalsetup', 'init');
$PAGE->requires->skip_link_to('loginsignin', get_string('login', 'local_alternatelogin'));
$PAGE->requires->skip_link_to('loginsignup', get_string('signup', 'local_alternatelogin'));

$renderer = $PAGE->get_renderer('local_alternatelogin');

if (empty($config->noheader)) {
    $PAGE->set_pagelayout('login');
    echo $OUTPUT->header();
} else {
    $PAGE->set_pagelayout('embedded');
    $PAGE->add_body_class('local-alternatelogin-login');
    echo $PAGE->requires->get_head_code($PAGE, $OUTPUT);
    echo $PAGE->requires->get_top_of_body_code($renderer);
}

echo $renderer->render_login_form();

echo $renderer->render_modal_info();

if (empty($config->nofooter)) {
    echo $OUTPUT->footer();
} else {
    echo $PAGE->requires->get_end_code();
}
