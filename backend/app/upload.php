<?php
/**
 * 用户上传文件配置
 */
define('UPLOAD_DIR', __DIR__.'/../public/uploads/');

$uploadConfigs = [
    'user_activity_image' => [
//        'width' => 1200,
//        'height' => 600,
        'size' => 2 * 1024 * 1024,
        'ext' => 'jpg,jpeg,png,bmp',
        'path' => UPLOAD_DIR.'activity_image'
    ]
];
return $uploadConfigs;
