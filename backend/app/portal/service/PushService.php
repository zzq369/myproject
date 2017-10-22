<?php
/**
 * 互推service
 */

namespace app\portal\service;


use app\portal\model\ProvinceModel;
use app\portal\model\PushCategoryModel;
use app\grab\model\PushModel;
use app\portal\model\PushCommentsModel;
use app\portal\model\PushTagsModel;
use app\portal\model\UserIndustryModel;
use app\user\model\UserModel;

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
        $result = $pushModel->getListBy($params,$field, 10);
        $list = $result->items();
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
        return array("list" => $list, "page" => $result->render());
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

    /**
     * 获取省份
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getProvinceList(){
        $provinceModel = new ProvinceModel();
        $list = $provinceModel->getList();
        return $list;
    }

    /**
     * 根据ID获取详情
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getPushInfo($id){
        $pushModel = new PushModel();
        $info = $pushModel->getInfoById($id);
        return $info;
    }

    /**
     * 获取商家详情
     * @param $user_id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getUserInfo($user_id){
        $userModel = new UserModel();
        $info = $userModel->getInfoById($user_id);
        return $info;
    }

    /**
     * 根据pushId获取评论
     * @param $push_id
     * @return \think\Paginator
     */
    public function getPushComments($pushId){
        $commentModel = new PushCommentsModel();
        $params = array('a.push_id'=>$pushId);
        $list = $commentModel->getListBy($params);
        return $list;
    }

    /**
     * 增加阅读量
     * @param $id
     * @return bool
     */
    public function addRead($id){
        $pushModel = new PushModel();
        $pushModel->where('id=' . $id)->setInc('read_count');
        return true;
    }
}