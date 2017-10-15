<?php
/**
 * 互推service
 */

namespace app\portal\service;


use app\portal\model\PushCategoryModel;
use app\grab\model\PushModel;
use app\portal\model\PushTagsModel;
use app\portal\model\UserIndustryModel;

class PushService
{
    /**
     * 获取推荐类型
     * @return mixed
     */
   public function getPushCategory(){
       $cateModel = new PushCategoryModel();
       $list = $cateModel->getList();
       return $list;
   }
    //获取最新互推资源
    public function getPush(){

        $pushModel = new PushModel();
        $params = array(
        );
        $field = "a.id,a.title,a.create_time,a.is_top,a.is_anxious,a.read_count,a.address,b.name as cate_name";
        $list = $pushModel->getListBy($params,$field, 10);
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

    /**
     * 获取行业
     * @return mixed
     */
    public function getIndustry(){
        $industryModel = new UserIndustryModel();
        $params = array(
            'status' => 1
        );
        $list = $industryModel->getList($params);
        return $list;
    }
}