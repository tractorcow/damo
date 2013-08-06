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


Commenting::set_config_value('SiteTree', 'use_gravatar', true);
