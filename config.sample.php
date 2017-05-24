<?php

// TM 09/12/2016
// Config options for Slackemon

// A reminder that Slackemon requires PHP7. Much of this config file assigns arrays as values to constants, which
// is not supported on prior versions of PHP.

define( 'SLACK_TOKENS', [

	// Slack App token
	// Please enter your token in place of the XXXXXXXXXXXXXXXXXXXXXXXX, and enter your team_id also
	// Make sure 'actions' and 'options' are set to true so that these validate for your app also
	'XXXXXXXXXXXXXXXXXXXXXXXX' => [
		'team_id' => 'TXXXXXXXX',
		'actions' => true,
		'options' => true,
		'commands' => [
			'/slackemon',
		],
	],

]);

// The username of the global team maintainer, who people can be directed to contact for help when
// errors occur. The array key is the team ID; the value is the user ID.
define( 'GLOBAL_MAINTAINERS', [
	'TXXXXXXXX' => 'UXXXXXXXX',
]);

// API keys for accessing external services
define( 'SERVICES', [

	'slack'   => [ 'key' => '' ],
	'weather' => [ 'key' => '' ],
	
]);

// Set a random token that cron.php will check for before running
// When you cron cron.php, make sure you send the token too - eg. cron.php?token=XXXXXXXXXXXXXXXXXXXX
// This protects the cron from being invoked by another source, which could result in multiple command runs
define( 'CRON_TOKEN', 'XXXXXXXXXXXXXXXXXXXX' );

// Cron schedule (will only work if cron.php is run every minute by your system)
define( 'CRON_SCHEDULE', [

	[ '*', '*', '*', '*', '*', [ '/slackemon maybe-spawn', 		 'UXXXXXXXX', 'TXXXXXXXX' ] ], // Runs every minute
	[ '*', '*', '*', '*', '*', [ '/slackemon battle-updates', 	 'UXXXXXXXX', 'TXXXXXXXX' ] ], // Runs every minute
	[ '1', '1', '*', '*', '*', [ '/slackemon happiness-updates', 'UXXXXXXXX', 'TXXXXXXXX' ] ], // Runs once a day

	//[ '*', '*', '*', '*', '*', [ '/command', 'UXXXXXXXX', 'TXXXXXXXX' ] ], // Runs every minute
		
	// The format is almost just like normal crons:
	//
	// 		[ 'MIN', 'HOUR', 'DATE', 'MONTH', 'DAY', [ '/COMMAND ARGS', 'USER-ID', 'TEAM-ID' ] ],
	//
	// For an individual Slashie to support cron, it MUST send through user_id and special_mode as POST vars when it
	// calls its subcommand. Immediate responses echo'ed out in a Slashie will NOT be returned to the user for cronned
	// commands. If this behaviour is desired outside of a subcommand, please use send2slack() rather than echo() when
	// writing the command.

]); // CRON_SCHEDULE

// The URL used for the image cache and for cron to trigger commands
// PLEASE INCLUDE THE TRAILING SLASH
define( 'INBOUND_URL', 'https://example.com/slackemon/' );

// Configure the image cache - two methods are supported; either local, or via an AWS S3 bucket (or you can disable)
// You should use the AWS option unless you are hosting Slackemon on a suitably fast server/connection
// If using the local option, please ensure your INBOUND_URL is correct!
define( 'SLACKEMON_IMAGE_CACHE', [

	'method' 	 => 'local', // 'aws', 'local', or 'disabled'
	'folder' 	 => __DIR__ . '/.image-cache', // Please start with __DIR__ then a slash, and don't end with a slash

	// Only required if using 'aws' above
	'aws_id' 	 => 'XXXXXXXXXXXXXXXXXXXX',
	'aws_secret' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
	'aws_region' => 'us-east-1', // 'us-east-1' is recommended, as it is the same region Slack uses!
	'aws_bucket' => 'slackemon',

]);

// Default timezone
// User specific timezones are not yet supported
date_default_timezone_set( 'Australia/Melbourne' );

// Weather location (default is Melbourne, Australia)
define( 'SLACKEMON_WEATHER_LAT_LON', '-37.81,144.96' );

// Default monetary locale
// Used for displaying the correct currency formatting
setlocale( LC_MONETARY, 'en_AU' );

// Global data folder
// If you change this, you might need to update .gitignore, so generally best to leave it!
//
// Please keep in mind:
// - Bad things may happen if you don't start the data folder with __DIR__
// - After the __DIR__, use a slash, but don't end with a slash
$data_folder = __DIR__ . '/.data';

// The end!
