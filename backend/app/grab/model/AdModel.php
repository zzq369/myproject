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

class AdModel extends Model
{
    public function addAd($data){
        $pushQuery = Db::name("ad");
        $saveData = [];
        $saveData['user_id'] = 2;
        $saveData['title'] = $data['title'];
        $saveData['address'] = $data['address'];
        $saveData['company_name'] = $data['company_name'];
        $saveData['type'] = $data['type'];
        $saveData['tel'] = $data['tel'];
        $saveData['content'] = $data['content'];
        $saveData['create_time'] = now_time();
        $saveData['update_time'] = now_time();
        $pushQuery->insertGetId($saveData);
        return true;
    }
}
