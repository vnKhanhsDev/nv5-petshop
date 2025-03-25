<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC <contact@vinades.vn>';
$lang_translator['createdate'] = '04/03/2010, 15:22';
$lang_translator['copyright'] = '@Copyright (C) 2009-2021 VINADES.,JSC. All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_global';

$lang_global['mod_authors'] = 'Administrators';
$lang_global['mod_groups'] = 'Group';
$lang_global['mod_database'] = 'Database';
$lang_global['mod_settings'] = 'Configuration';
$lang_global['mod_cronjobs'] = 'Automatic process';
$lang_global['mod_modules'] = 'Modules';
$lang_global['mod_themes'] = 'Themes';
$lang_global['mod_siteinfo'] = 'Informations';
$lang_global['mod_language'] = 'Language, Region';
$lang_global['mod_upload'] = 'Upload';
$lang_global['mod_webtools'] = 'Webtools';
$lang_global['mod_seotools'] = 'SEO tool';
$lang_global['mod_subsite'] = 'Subsite manage';
$lang_global['mod_extensions'] = 'Extensions';
$lang_global['mod_zalo'] = 'Zalo';
$lang_global['mod_emailtemplates'] = 'Email templates';
$lang_global['go_clientsector'] = 'Home page';
$lang_global['go_clientmod'] = 'Preview';
$lang_global['go_instrucion'] = 'Instruction document';
$lang_global['please_select'] = 'Please select';
$lang_global['admin_password_empty'] = 'Administrator password has not been declared';
$lang_global['adminpassincorrect'] = 'Administrator password &ldquo;<strong>%s</strong>&rdquo; is inaccurate. Try again';
$lang_global['admin_password'] = 'Password';
$lang_global['admin_no_allow_func'] = 'You can\'t access this function';
$lang_global['admin_suspend'] = 'Account Suspended';
$lang_global['block_modules'] = 'Block in modules';
$lang_global['hello_admin1'] = 'You last logged in to your administrator account at %1$s via IP address %2$s';
$lang_global['hello_admin2'] = 'You logged at %1$s via IP address %2$s';
$lang_global['ftp_error_account'] = 'Error: Can\'t connect to FTP server, please check FTP configuration';
$lang_global['ftp_error_path'] = 'Error: Wrong configuration in Remote path';
$lang_global['login_error_account'] = 'Error: Username was not announced or declared invalid. (Only letters, numbers and underscores the Latin alphabet. Minimum %1$s characters, maximum %1$s characters)';
$lang_global['login_error_password'] = 'Error: Password has not announced or declared invalid. (Only letters, numbers and underscores the Latin alphabet. Minimum %1$s characters, maximum %1$s characters)';
$lang_global['login_error_security'] = 'Error: Security Code not valid ! (Only Latin alphabet. Must have %1$s characters)';
$lang_global['error_zlib_support'] = 'Error: Your server does not support zlib extension, You need contact your hosting provider to enable the zlib extension.';
$lang_global['error_zip_extension'] = 'Error: Your server does not support ZIP extension, You need contact your hosting provider to enable the ZIP extension.';
$lang_global['length_characters'] = 'Length characters';
$lang_global['length_suggest_max'] = 'Should enter maximum %s characters';
$lang_global['phone_note_title'] = 'Rules of entering phone numbers';
$lang_global['phone_note_content'] = '<ul><li>Phone number is divided into two parts. The first part is mandatory and for display on the site, the second part is not mandatory, and to make a call when you click on it.</li><li>The first part is expressed freely, but without the square brackets. The second part is in square brackets and contains only the following characters: digits, asterisk, pound sign, commas, periods, semicolons, and the plus sign ([0-9\*\#\.\,\;\+]).</li><li>For example, if you declare <strong>0438211725 (ext 601)</strong>, the number <strong>0438211725 (ext 601)</strong> will simply be displayed on the site. If you declare <strong>0438211725 (ext 601)[+84438211725,601]</strong>, the system will display the number <strong>0438211725 (ext 601)</strong> on the site. When clicked on this number will automatically call the following number <strong>tel:+84438211725,601</strong></li><li>You can declare more phone numbers in accordance with the above regulations. They are separated by |</li></ul>';
$lang_global['phone_note_content2'] = '<ul><li>Phone number is divided into two parts. The first part is mandatory and for display on the site, the second part is not mandatory, and to make a call when you click on it.</li><li>The first part is expressed freely, but without the square brackets. The second part is in square brackets and contains only the following characters: digits, asterisk, pound sign, commas, periods, semicolons, and the plus sign ([0-9\*\#\.\,\;\+]).</li><li>For example, if you declare <strong>0438211725 (ext 601)</strong>, the number <strong>0438211725 (ext 601)</strong> will simply be displayed on the site. If you declare <strong>0438211725 (ext 601)[+84438211725,601]</strong>, the system will display the number <strong>0438211725 (ext 601)</strong> on the site. When clicked on this number will automatically call the following number <strong>tel:+84438211725,601</strong></li></ul>';
$lang_global['multi_note'] = 'You can enter more than one value, separated by comma';
$lang_global['multi_email_note'] = 'You can enter more than one value, separated by comma. The first e-mail is considered to be the main email and is used to send and receive mail.';
$lang_global['view_all'] = 'View all';
$lang_global['email'] = 'Email';
$lang_global['phonenumber'] = 'Phone';
$lang_global['admin_pre_logout'] = 'Not me, log out';
$lang_global['admin_hello_2step'] = 'Hi <strong class="admin-name">%s</strong>, please verify your account';
$lang_global['admin_noopts_2step'] = 'No two-step verification method has been granted, temporarily you cannot log in to the administrator';
$lang_global['admin_mactive_2step'] = 'You cannot verify because no method has been activated yet';
$lang_global['admin_mactive_2step_choose0'] = 'Please click the button below to activate the verification method';
$lang_global['admin_mactive_2step_choose1'] = 'Please select one of the verification methods below';
$lang_global['admin_2step_opt_code'] = '2-Step Verification Code';
$lang_global['admin_2step_opt_facebook'] = 'Facebook account';
$lang_global['admin_2step_opt_google'] = 'Google account';
$lang_global['admin_2step_opt_zalo'] = 'Zalo account';
$lang_global['admin_2step_opt_key'] = 'Passkey or Security key';
$lang_global['admin_setup_2fa_keycode'] = '2FA application or access key';
$lang_global['admin_2step_other'] = 'Other methods';
$lang_global['admin_oauth_error_getdata'] = 'Error: The system did not recognize the verification data. Verification failed!';
$lang_global['admin_oauth_error_email'] = 'Error: The return email is not valid, you cannot verification';
$lang_global['admin_oauth_error_savenew'] = 'Error: Unable to save the verification data';
$lang_global['admin_oauth_error'] = 'Error: The verification is not valid, this account has not been authorized to verify';
$lang_global['acp'] = 'Site management';
$lang_global['login_session_expire'] = 'Your login session will expire in';
$lang_global['account_settings'] = 'Account settings';
$lang_global['your_admin_account'] = 'Your admin account';
$lang_global['login_name'] = 'Login name';
$lang_global['login_name_type_username'] = 'Username';
$lang_global['login_name_type_email'] = 'Email';
$lang_global['login_name_type_email_username'] = 'Username or Email';
$lang_global['interface_current_menu'] = 'Current module';
$lang_global['interface_other_menu'] = 'Other modules';

$lang_global['merge_field_author_delete_time'] = 'Deletion time';
$lang_global['merge_field_author_delete_reason'] = 'Reason for deletion';
$lang_global['merge_field_contact_link'] = 'Contact link';
$lang_global['merge_field_is_suspend'] = 'Suspend (1) or re-enable (0)';
$lang_global['merge_field_time'] = 'Execution time';
$lang_global['merge_field_reason'] = 'Reason for implementation';
$lang_global['merge_field_sys_siteurl'] = 'Base site url';
$lang_global['merge_field_sys_nv'] = 'Module var';
$lang_global['merge_field_sys_op'] = 'Op var';
$lang_global['merge_field_sys_langvar'] = 'Language var';
$lang_global['merge_field_sys_langdata'] = 'Lang data';
$lang_global['merge_field_sys_langinterface'] = 'Lang interface';
$lang_global['merge_field_sys_assetsdir'] = 'Thumb dir of system';
$lang_global['merge_field_sys_filesdir'] = 'Thumb dir of module';
