<?php
$webroot = '/home/website/public_html';

require_once $webroot.'/vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use GuzzleHttp\ClientInterface;
use Dotenv\Dotenv;

/* read environment variables */
$dotenv = new Dotenv($webroot);
$dotenv->load();

$sparkpostSecret = getenv('SPARKPOST_SECRET');
$appEmail = getenv('APP_EMAIL');
$appName = getenv('APP_NAME');
$branch = getenv('BRANCH');
$slackHook = getenv('SLACK_HOOK');

$guzzleClient = new Client();

/* create sparkpost email adapter */
$httpAdapter = new GuzzleAdapter($guzzleClient);
$sparkPost = new SparkPost($httpAdapter, ['key' => $sparkpostSecret ]);

/* check if composer needs update */
exec('cd '.$webroot.'; export COMPOSER_HOME=/home/website; /usr/bin/composer install --dry-run 2>&1', $checkComposer);

foreach ($checkComposer as $message) {
  if (preg_match('~composer self-update~', $message)) {
    $composerActions['composerUpdate'] = true;
  }
  if (preg_match('~(- Updating|- Installing)~', $message)) {
    $composerActions['dependencyUpdate'] = true;
  }
}

if (isset($composerActions['composerUpdate'])) {
  exec('cd '.$webroot.'; export COMPOSER_HOME=/home/website; /usr/bin/composer self-update 2>&1');
}

/* run the unit tests */
exec($webroot . '/tests/codeception/public_tests.sh', $testResults);

$status['failed'] = false;

$bitbucketPayload = "Manual execution - no payload supplied.";
if (isset($argv[1])) {
    $bitbucketPayload = $argv[1];
}

$outputPath = $webroot .'/tests/codeception/tests/_output';
$reportJson = $outputPath.'/report.json';
$reportTapLog = $outputPath.'/report.tap.log';

$jsonOutput = file_get_contents($reportJson);
$tapOutput = file_get_contents($reportTapLog);

/* Build message headers */
$body['from'] = 'PHP Unit Test';
$body['payload'] = "Payload: ".$bitbucketPayload."\n\n";
$body['composer'] = "Composer: Dependency Update Required";

if (preg_match('~(Failure|Error)~', $tapOutput)) {
  $emoji = ':x:';
  $body['subject'] = '[FAILED] '.$body['from'];
  preg_match('~"message": "(.+)"~', $jsonOutput, $message);
  $body['message'] = "Message: ```".str_replace(['\t', '\n'], '', $message[1])."```";
} else {
  $emoji = ':white_check_mark:';
  $body['subject'] = '[passed] '.$body['from'];
  $body['message'] = null;
}

try {

  $body['html'] = "Subject: ".$emoji." *".$body['subject']."*\n\n";

  if (isset($composerActions['dependencyUpdate'])) { 
    $body['html'] .= $body['composer'].":exclamation: \n\n";
  }

  $body['html'] .= $body['message'];
  $body['html'] .= $body['payload'];

  $slackPayload = json_encode([
    'text'       => $body['html'],
    'username'   => $body['from'],
    'icon_emoji' => ':syringe:'
  ]);

  $guzzleClient->request('POST', $slackHook, ['body' => $slackPayload]);

} catch (Exception $e) {

  $body['html'] = "Subject: ".$body['subject']."\n\n";

  if (isset($composerUpdateRequired)) { 
    $body['html'] .= $body['composer']."\n\n";
  }

  $body['html'] .= $body['message'];
  $body['html'] .= 'Exception: '.$e->getMessage();
  $body['html'] .= $body['payload'];

  $sparkPost->transmission->send([
    'from' => $body['from'].' <'.$appEmail.'>',
    'html' => nl2br($body['html']),
    'subject' => 'SLACK API FAILED: '.$body['subject'],
    'recipients' => [
      [
        'address' => [
          'name' => 'Air Aroma',
          'email' => $appEmail
        ]
      ]
    ]
  ]);
}

/* remove old reports */
array_map('unlink', glob($outputPath.'/*.html'));
unlink($reportJson);
unlink($reportTapLog);
