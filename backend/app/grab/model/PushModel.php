<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Powerless < wzxaini9@gmail.com>
// +----------------------------------------------------------------------
namespace app\grab\model;

use think\Db;
use think\Model;

class PushModel extends Model
{
    public function addPush($data){
        $pushQuery = Db::name("push");
        $saveData = [];
        $saveData['user_id'] = 1;
        $saveData['title'] = $data['title'];
        $saveData['create_time'] = now_time();
        $saveData['update_time'] = now_time();
        $pushQuery->insertGetId($saveData);
        return true;
    }

    /**
     * title获取互推详情
     * @param $title
     * @return array|false|\PDOStatement|string|Model
     */
    public function getInfoByTitle($title){
        $pushQuery = Db::name("push");
        $info = $pushQuery->where('title', $title)->find();
        return $info;
    }
}
