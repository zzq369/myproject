<?php
/**
 * 商家互推留言
 */
namespace app\portal\model;

use think\Db;
use think\Model;

class PushCommentsModel extends Model
{
    /**
     * 根据条件获取列表
     * @param $params
     */
    public function getListBy($params){
        $pushQuery = Db::name("push_comments");
        $list = $pushQuery->alias("a")
            ->field('a.id,a.comment_user_id,a.content,u.user_nickname,u.avatar')
            ->join('__USER__ u','a.comment_user_id = u.id', 'LEFT')
            ->where($params)
            ->order("id desc")->paginate(10);
        return $list;
    }
}

