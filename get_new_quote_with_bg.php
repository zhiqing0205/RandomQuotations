<?php
require('./config.php');
require('./class/mysql_class.php');

$con = new Sql($db_host, $db_user, $db_pwd);
$con->connect_mysql($db_database);
$con->charset();

$sql = "SELECT txt FROM `rains_own` ORDER BY RAND() LIMIT 1";
$query = $con->query($sql);
$list = $query->fetchAll();

// echo $list[0]['txt']; // 返回一条随机语录
$quote = $list[0]['txt'];

$mobilePath = './resource/img/bing/mobile/';
$pcPath = './resource/img/bing/pc/';

// 从请求中获取设备类型
$deviceType = isset($_GET['deviceType']) ? $_GET['deviceType'] : 'pc';

// 选择正确的路径
$path = ($deviceType === 'mobile') ? $mobilePath : $pcPath;

// 扫描文件夹中的所有文件
$files = array_diff(scandir($path), array('.', '..'));

// 随机选择一个文件
$randomFile = $files[array_rand($files)];
// echo $path . $randomFile;

$backgroundImageUrl = $path . $randomFile;

// 将语录和背景图URL一起作为JSON返回
$response = array("quote" => $quote, "backgroundImage" => $backgroundImageUrl);
echo json_encode($response);

?>