<?php
/**
 * 省份表
 */
namespace app\portal\model;

use think\Db;
use think\Model;

class ProvinceModel extends Model
{
    /**
     * 根据条件获取列表
     * @param $params
     */
    public function getList(){
        $pushQuery = Db::name("province");
        $list = $pushQuery->field('id,name')->order("id asc")->select();
        return $list;
    }
}

