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
namespace app\portal\model;

use think\Db;
use think\Model;

class PushCategoryModel extends Model
{
    /**
     * 根据条件获取列表
     * @param $params
     */
    public function getList(){
        $pushQuery = Db::name("push_category");
        $list = $pushQuery->field('id,name')->order("id asc")->select();
        return $list;
    }
}

