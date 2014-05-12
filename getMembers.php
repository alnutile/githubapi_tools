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

$members_array = [];

$results = new ResultPager($client);

$all_members = $results->fetchAll($client->api('organization')->members(), 'all', [$orgname]);
foreach($all_members as $value) {
    $user_info = 'too hard to get via api';
    $email = $user_info;
    $members_array[] = [
      'username' => $value['login'],
      'email'    => $email
    ];
}

$csvFile = new CsvFile(__DIR__ . '/members.csv');

foreach ($members_array as $row) {
    $csvFile->writeRow($row);
}