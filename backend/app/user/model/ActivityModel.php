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
namespace app\user\model;

use think\Db;
use think\Model;

class ActivityModel extends Model
{
    public function saveActivity($data){
        $query = Db::name("activity");
        $data['user_id'] = session('user.id');
        $data['update_time'] = now_time();
        if($data['id']){
            $id = $data['id'];
            unset($data['user_id'],$data['id']);
            $query->where(array('id'=>$id,'user_id'=>session('user.id')))->update($data);
        }else{
            $data['create_time'] = now_time();
            $id = $query->insertGetId($data);
        }
        if ($id) {
            return $id;
        } else {
            return false;
        }
    }

    /**
     * title获取互推详情
     * @param $title
     * @return array|false|\PDOStatement|string|Model
     */
    public function getInfoByTitle($title){
        $query = Db::name("activity");
        $info = $query->where('title', $title)->find();
        return $info;
    }

    /**
     * id获取互推详情
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public function getInfoById($id){
        $query = Db::name("activity");
        $info = $query
            ->where('id', $id)
            ->find();
        return $info;
    }

    /**
     * 根据条件获取列表
     * @param $params
     */
    public function getListBy($params, $field = "*", $limit = 5){
        $query = Db::name("activity");
        $list = $query->alias("a")->field($field)
            ->where($params)->limit($limit)->order("a.update_time desc")->paginate(10);
        return $list;
    }
}

