<?php

require_once 'vendor/autoload.php';
use Github\Client;
use Github\ResultPager;
use Keboola\Csv\CsvFile;

\Dotenv::load(__DIR__);

$client = new Client();

//1 get members
$user_name = $_ENV['USER_NAME'];
$token = $_ENV['TOKEN'];
$orgname = $_ENV['ORG_NAME'];

$client->authenticate($user_name, $token, null);

$teams_array = [];

$results = new ResultPager($client);

$all_teams = $results->fetchAll($client->api('organization')->teams(), 'all', [$orgname]);
foreach($all_teams as $value) {
    $teams_array[] = [
      'name' => $value['name'],
      'members_url'    => $value['members_url']
    ];
}

$csvFile = new CsvFile(__DIR__ . '/teams.csv');

foreach ($teams_array as $row) {
    $csvFile->writeRow($row);
}