<?php
/**
 * 地区model
 */
namespace app\user\model;

use think\Model;

class RegionModel extends Model
{
    public function getListsBy($params){
        $params['Id'] = array("neq", 0);
        $list = $this->where($params)->select()->toArray();
        if($list[0]['name'] == '市辖区'){
            $params['pid'] = $list[0]['Id'];
            $list = $this->where($params)->select()->toArray();
        }
        return $list;
    }
}
