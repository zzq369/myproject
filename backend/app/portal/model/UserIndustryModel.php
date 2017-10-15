<?php
/**
 * 商家行业
 */
namespace app\portal\model;

use think\Db;
use think\Model;

class UserIndustryModel extends Model
{
    /**
     * 根据条件获取列表
     * @param $params
     */
    public function getList($params){
        $pushQuery = Db::name("user_industry");
        $list = $pushQuery->field('id,name')->where($params)->order("id asc")->select();
        return $list;
    }
}

