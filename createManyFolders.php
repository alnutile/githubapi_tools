<?php

require_once 'vendor/autoload.php';
use Github\Client;
use Github\ResultPager;
use Keboola\Csv\CsvFile;

\Dotenv::load(__DIR__);

$client = new Client();
$not_working = [];
$user_name = $_ENV['USER_NAME'];
$token = $_ENV['TOKEN'];
$orgname = $_ENV['ORG_NAME'];

$path_and_filename = 'some/path/file.txt';

$name_of_account = $user_name;

$content = <<<HEREDOC
 'some content'
HEREDOC;

$message = "some commit message";

$branch = "master";

//You commit info
$me = array(
    'name'       => $_ENV['GIT_NAME'],
    'email'      => $_ENV['GIT_EMAIL']
);

$the_list_of_repos = array('bbbbb_test');

$client->authenticate($user_name, $token, null);

foreach($the_list_of_repos as $repo_name) {
    print "Working on $repo_name \n";
    try {
        $output = $client->api('repos')->contents()->show($name_of_account, $repo_name, $path_and_filename, $branch);
        $sha = $output['sha'];
        var_dump($sha);
        print "Already Exists \n";
        break;
    }
    catch(\Github\Exception\RuntimeException $e) {
        print "Not Found $path_and_filename so going to make it \n";
    }

    try {
        $output = $client->api('repos')->contents()->create($name_of_account, $repo_name, $path_and_filename, $content, $message, $branch, $me);
    }

    catch(\Github\Exception\RuntimeException $e) {
        $not_working[] = array('name'=>$repo_name, 'error' => $e->getMessage());
    }

    catch(Github\Exception\ValidationFailedException $e) {
        $not_working[] = array('name'=>$repo_name, 'error' => $e->getMessage());
    }

}

$csvFile = new CsvFile(__DIR__ . '/notworking.csv');

foreach ($not_working as $row) {
    $csvFile->writeRow($row);
}