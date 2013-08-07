<?php

global $project;
$project = 'mysite';

global $database;
$database = 'ssblog_db';

// Fulltext setup
FulltextSearchable::enable();

// Set the site locale
i18n::set_locale('en_NZ');

require_once("conf/ConfigureFromEnv.php");

Requirements::set_combined_files_enabled('true');

if (!Director::isDev()) {
    SS_Log::add_writer(new SS_LogEmailWriter('damian.mooyman@gmail.com'), SS_Log::ERR);
}

// Setup recaptcha from _ss_environment
if(defined('SS_RECAPTCHA_PUBLIC') && defined('SS_RECAPTCHA_PRIVATE')) {
	RecaptchaField::$public_api_key = SS_RECAPTCHA_PUBLIC;
	RecaptchaField::$private_api_key = SS_RECAPTCHA_PRIVATE;
	SpamProtectorManager::set_spam_protector('RecaptchaProtector');
}

Commenting::set_config_value('SiteTree', 'use_gravatar', true);
