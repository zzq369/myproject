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

    /**
     * id获取互推详情
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public function getInfoById($id){
        $pushQuery = Db::name("push");
        $info = $pushQuery->where('id', $id)->find();
        return $info;
    }

    /**
     * 根据条件获取列表
     * @param $params
     */
    public function getListBy($params, $field = "*", $limit = 5){
        $pushQuery = Db::name("push");
        $list = $pushQuery->alias("a")->field($field)
            ->join("__PUSH_CATEGORY__ b","a.category_id = b.id","LEFT")
            ->where($params)->limit($limit)->order("id desc")->paginate(10);
        return $list;
    }
}

