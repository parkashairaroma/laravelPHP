<?php
$webroot = realpath($_SERVER['DOCUMENT_ROOT'] . '..'); //New Dynamic Path

require_once $webroot.'/vendor/autoload.php';
require_once $webroot.'/deploy/Deploy.php';

/* read environment variables */
$dotenv = new Dotenv\Dotenv($webroot);
$dotenv->load();

$branch = trim(getenv('BRANCH'));
$branches = [];

/* parse bitbucket request json string */
$payload = json_decode(file_get_contents('php://input'), true);

/* determine branch name */
if (! $branch) {
    echo 'Please set BRANCH in .env';
    exit;
}

if(isset($payload['push']['changes']) && count($payload['push']['changes'])>0) {
    /* is the commit for this branch? */
    foreach ($payload['push']['changes'] as $changes) {
        $branches[$changes['new']['name']] = [
            'commit' => $changes['new']['target']['hash'],
            'name' => $changes['new']['target']['author']['user']['display_name']
        ];
    }
}
else
{
    
}

if (array_key_exists($branch, $branches)) {

    $status['branch'] = $branch;

    $options = [
        'log' => $webroot.'/storage/logs/deploy/deployments.log',
        'branch' => $branch,
        'remote' => 'origin'
    ];

    /* init deploy script */
    $deploy = new Deploy($webroot, $options);
    $deploy->execute();

    /* set permissions of pulled files */
    exec('chmod +x '.$webroot.'/tests/codeception/public_tests.sh');
    exec('chmod +x '.$webroot.'/tests/codeception/admin_tests.sh');
    exec('chmod +x '.$webroot.'/tests/codeception/codecept');

    /* run the unit tests */
    exec('php '.$webroot.'/deploy/unittests.php '.json_encode($branches).' > /dev/null 2>&1 &');

    echo json_encode(['deployment' => 'successful', 'info' => $branches]);
}
