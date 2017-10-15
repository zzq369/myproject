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

use app\admin\model\SlideItemModel;
use app\grab\model\PushModel;
use app\portal\model\PushTagsModel;
use app\portal\model\PortalPostModel;


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

    //获取首页推荐文章
    public function getRecommendPortal(){
        $portalModel = new PortalPostModel();
        $params = array(
            'post_type' => 1,
            'post_format' => 1,
            'post_status' => 1,
            'recommended' => 1
        );
        $field = 'id,post_title,update_time,more';
        $list = $portalModel->getListBy($params, $field, 10);
        if($list) {
            foreach ($list as $key=>&$val) {
                if(empty($val['more'])) continue;
                $more = json_decode($val['more'], true);
                if(isset($more['photos'])){
                    $val['pic'] = $more['photos'][0]['url'];
                }
                $list[$key] = $val;
            }
        }
        return $list;

    }

    //首页banner
    public function getBanner(){
        $slideModel = new SlideItemModel();
        $params = array(
            'slide_id' => 1,
            'status' => 1
        );
        $list = $slideModel->getListBy($params);
        return $list;
    }

}