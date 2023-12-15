<?php
require('./config.php');
require('./class/mysql_class.php');

$con = new Sql($db_host, $db_user, $db_pwd);
$con->connect_mysql($db_database);
$con->charset();

$sql = "SELECT txt, `time` FROM `rains_own` ORDER BY RAND() * UNIX_TIMESTAMP(`time`) DESC LIMIT 1";
$query = $con->query($sql);
$list = $query->fetchAll();

$quote = $list[0]['txt'];
$quoteTime = new DateTime($list[0]['time']);
$currentTime = new DateTime();
$interval = $currentTime->diff($quoteTime);

$mobilePath = './resource/img/bing/mobile/';
$pcPath = './resource/img/bing/pc/';

$deviceType = isset($_GET['deviceType']) ? $_GET['deviceType'] : 'pc';
$path = ($deviceType === 'mobile') ? $mobilePath : $pcPath;

$files = array_diff(scandir($path), array('.', '..'));
$randomFile = $files[array_rand($files)];
$backgroundImageUrl = $path . $randomFile;

$response = array(
    "quote" => $quote, 
    "backgroundImage" => $backgroundImageUrl,
    "is_new" => $interval->days <= 3 ? true : false // 设置 is_new 值
);

echo json_encode($response);
?>
