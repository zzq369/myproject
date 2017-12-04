<?php
/**
 * 用户上传文件配置
 */
define('UPLOAD_DIR', __DIR__.'/../public/uploads/'); //实际路径
define('UPLOAD_REL_DIR', '/uploads/'); //相对路径

$uploadConfigs = [
    'user_activity_image' => [
//        'width' => 1200,
//        'height' => 600,
        'size' => 2 * 1024 * 1024,
        'ext' => 'jpg,jpeg,png,bmp',
        'dir' => UPLOAD_DIR.'activity_image',
        'rel_dir' => UPLOAD_REL_DIR .'activity_image',
    ]
];
return $uploadConfigs;
