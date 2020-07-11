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

defined('MOODLE_INTERNAL') || die();

$string['privacy:metadata'] = 'This plugin does not hold any personal data by itself.';

$string['accountcreated'] = 'Account created';
$string['alternatelogin'] = 'Alternate login page setup';
$string['alternatelogin_help'] = '<a href="{$a}">See login page</a>';
$string['arialabel'] = 'Site logo';
$string['appearance'] = 'Appearance';
$string['captchainstr'] = 'Copy the numbers above in the same order';
$string['close'] = 'Close';
$string['configaccepteddomains'] = 'Accepted domains';
$string['configaccepteddomains_desc'] = 'If not empty, tells the list of mail domains the signup is allowed for';
$string['configenabled'] = 'Enabled';
$string['configenabled_desc'] = 'Allows or disallows use of this page';
$string['configextracss'] = 'Extra CSS';
$string['configextracss_desc'] = 'Extra CSS rules for the alternate login page';
$string['configloginusesmail'] = 'Login uses mail';
$string['configloginusesmail_desc'] = 'Adds an "email" signal on the form';
$string['configmodalinfo'] = 'Modal additional info';
$string['configmodalinfo_desc'] = 'If enabled, will add a modal popup openable with a link having href="#alternate-login-info" and rel="modal:open" ';
$string['configmodaltitle'] = 'Modal additional title';
$string['configmodaltitle_desc'] = 'Sets the caption of the modal dialog ';
$string['confignofooter'] = 'No footer';
$string['confignofooter_desc'] = 'If enabled, will not print the footer';
$string['confignoheader'] = 'No header';
$string['confignoheader_desc'] = 'If enabled, will not print the header';
$string['configprofilefield'] = 'Profile field for values';
$string['configprofilefield_desc'] = 'Shortname of a profile field that provides choices for panel 2 of signup';
$string['configrendererimages'] = 'Renderer images';
$string['configrendererimages_desc'] = 'A set of images that can be called by the login page renderer. these images are addressable from the extra CSS below, using {{#pluginfile}}<filename>{{/pluginfile}} syntax.';
$string['configresultingauthmethod'] = 'Resulting auth method';
$string['configresultingauthmethod_desc'] = 'All created accounts using alternate login will be assigned to this auth method';
$string['configsignuptext'] = 'Signup text';
$string['configsignuptext_desc'] = 'If enabled, will add a signup text.';
$string['configstylesheets'] = 'Stylesheets';
$string['configstylesheets_desc'] = 'A comma separated list of usefull stylesheets from the theme to use, when header is off';
$string['configwelcometext'] = 'Welcome text';
$string['configwelcometext_desc'] = 'Welcome text. If empty, will remove panel.';
$string['configwithcapcha'] = 'Use capcha';
$string['configwithcapcha_desc'] = 'If enables adds a cpacha at the end of the signup process.';
$string['confirmpassword'] = 'Password (confirmation)';
$string['defaultlogin'] = 'john.doe@gmail.com';
$string['dologin'] = 'Log in';
$string['email'] = 'Email';
$string['emailconfirm'] = 'Email address (confirmation)';
$string['errorcapchacheck'] = 'The capcha has failed.';
$string['errorempty'] = 'Field needs non empty value';
$string['errornotinvaliddomains'] = 'Your email needs to be in an accepted domain';
$string['errorexists'] = 'Email is already used.';
$string['errorexistsinternal'] = 'This email is used by and internal account.';
$string['errormalformed'] = 'email is malformed.';
$string['errornomatch'] = 'Values do not match';
$string['errorpasswordpolicy'] = 'The password does not match the policy';
$string['login'] = 'login';
$string['loginerror1'] = '<span data-error=\"{$a->error}\">Cookies cannot be used. Session cannot be stored in your browser.</span>';
$string['loginerror2'] = '<span data-error=\"{$a->error}\">Login is malformed.</span>';
$string['loginerror3'] = '<span data-error=\"{$a->error}\">Most likely the password did not match for this user.</span>';
$string['loginerror4'] = '<span data-error=\"{$a->error}\">User is locked out.</span>';
$string['loginerror5'] = '<span data-error=\"{$a->error}\">User is not authorised.</span>';
$string['loginerror6'] = '<span data-error=\"{$a->error}\">User has no account.</span>';
$string['loginerror99'] = '<span data-error=\"{$a->error}\">Other error (error ID \'{$a->error}\').</span>';
$string['loginoremail'] = 'login (or email)';
$string['mydashboard'] = 'My dashbord';
$string['newaccount'] = 'New account';
$string['newuser'] = 'New user';
$string['nopaste'] = 'Copy/paste are disabled on these fields';
$string['pluginname'] = 'Alternate login page';
$string['send'] = 'Create the account';
$string['signin'] = 'Sign in';
$string['signup'] = 'Sign up';
$string['sitealternatename'] = 'Learning site';
$string['tosignin'] = 'Go to Sign in';
$string['tosignup'] = 'Go to Sign up';

$string['emailconfirmationsubject'] = '{$a} - Confirm your account';
$string['confirminstructions'] = '
<p>Your account has been created and is in an <b>unconfirmed</b> state.</p>
<p>You will receive a confirmation email at <b>{$a}</b>.
Please watch your mailbox and click on the confirm link to activate your account.</p>
';

$string['emailconfirmation'] = '
Your account is waiting for you.

Please follow this link to confirm your account: {$a->link}
';


