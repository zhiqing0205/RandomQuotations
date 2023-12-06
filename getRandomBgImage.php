<?php
$mobilePath = './resource/img/bing/mobile/';
$pcPath = './resource/img/bing/pc/';

// 从请求中获取设备类型
$deviceType = isset($_GET['deviceType']) ? $_GET['deviceType'] : 'pc';

// 选择正确的路径
$path = ($deviceType === 'mobile') ? $mobilePath : $pcPath;

// 扫描文件夹中的所有文件
$files = array_diff(scandir($path), array('.', '..'));

// 随机选择一个文件
if (count($files) > 0) {
    $randomFile = $files[array_rand($files)];
    echo $path . $randomFile;
} else {
    echo "No images found.";
}
?>
