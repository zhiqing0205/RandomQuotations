<?php
require('./config.php');
require('./class/mysql_class.php');

$con = new Sql($db_host, $db_user, $db_pwd);
$con->connect_mysql($db_database);
$con->charset();

$sql = "SELECT txt FROM `rains_own` ORDER BY RAND() LIMIT 1";
$query = $con->query($sql);
$list = $query->fetchAll();

echo $list[0]['txt']; // 返回一条随机语录
?>
