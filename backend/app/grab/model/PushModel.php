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
    public function savePush($data){
        $pushQuery = Db::name("push");
        $data['user_id'] = session('user.id');
        $data['update_time'] = now_time();
        if($data['id']){
            $id = $data['id'];
            unset($data['user_id'],$data['id']);
            $pushQuery->where(array('id'=>$id,'user_id'=>session('user.id')))->update($data);
        }else{
            $data['create_time'] = now_time();
            $id = $pushQuery->insertGetId($data);
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
        $info = $pushQuery
            ->where('id', $id)
            ->find();
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
            ->join("__REGION__ p","a.province = p.id","LEFT")
            ->join("__REGION__ c","a.city = c.id","LEFT")
            ->join("__REGION__ ar","a.area = ar.id","LEFT")
            ->where($params)->limit($limit)->order("a.update_time desc")->paginate($limit);
        return $list;
    }
}

