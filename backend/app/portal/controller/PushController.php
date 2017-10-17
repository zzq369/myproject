<?php
/**
 * 互推页面
 */
namespace app\portal\controller;

use app\portal\service\PushService;
use cmf\controller\HomeBaseController;

class PushController extends HomeBaseController
{
    /**
     * 互推首页
     * @return mixed
     */
    public function index()
    {
        $service = new PushService();
        $categoryList = $service->getPushCategory();
        $pushList = $service->getPush();
        $industryList = $service->getIndustry();
        $provinceList = $service->getProvinceList();

        $this->assign('categoryList', $categoryList);
        $this->assign('pushList', $pushList['list']);
        $this->assign('page', $pushList['page']);
        $this->assign("industryList", $industryList);
        $this->assign("provinceList", $provinceList);
        return $this->fetch(':push_index');
    }
    /**
     * 互推详情页
     */
    public function detail(){
        //获取详情
        $id =  $this->request->get("id");
        $service = new PushService();
        $pushInfo = $service->getPushInfo($id);
        if(empty($pushInfo)){
            $this->error('互推信息不存在');
        }
        $user_id = $pushInfo['user_id'];
        //获取商家详情
        $userInfo = $service->getUserInfo($user_id);

        $this->assign('pushInfo', $pushInfo);
        $this->assign('userInfo', $userInfo);

        return $this->fetch(':push_detail');
    }

    /**
     * 异步获取留言列表
     */
    public function ajaxGetCommentsList(){
        $pushId = $this->request->get('push_id');
        $service = new PushService();
        $list = $service->getPushComments($pushId);
        $result = array(
            'list' => $list['list'],
            'page' => $list['page']
        );
        $this->result($result, 1, '获取成功' );
    }
}
