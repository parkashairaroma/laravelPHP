<?php
require_once __DIR__ .'/../vendor/autoload.php';

/* read environment variables */
$dotenv = new Dotenv\Dotenv(__DIR__ .'/../');
$dotenv->load();

$appurl = trim(websiteUrl());

use WebCrawler\Client;

$crawler = new Client($appurl);

$crawler->setOptions([
	'logFile' => 'crawls.log', 
	'logPath' => 'logs/', 
	'debug' => true
]);

$output = $crawler->init();
