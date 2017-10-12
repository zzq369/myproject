<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\service;

use app\grab\model\PushModel;
use app\portal\model\PushTagsModel;

class IndexService
{
    //获取最新互推资源
    public function getTopPush(){

        $pushModel = new PushModel();
        $params = array(
            'a.is_top' => 1
        );
        $field = "a.id,a.title,a.create_time,a.is_top,a.is_anxious,a.read_count,a.address,b.name as cate_name";
        $list = $pushModel->getListBy($params,$field, 5);
        if($list){
            $tagsModel = new PushTagsModel();
            foreach($list as $key=>&$val){
                //获取标签
                $paramsTags = array(
                    'push_id' => $val['id']
                );
                $tagsList = $tagsModel->getListBy($paramsTags);
                $val['tags'] = $tagsList;
                $list[$key] = $val;
            }
        }
        return $list;
    }

}