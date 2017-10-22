<?php
/**
 * 商家页面
 */
namespace app\portal\controller;

use app\portal\service\BusinessService;
use app\portal\service\PushService;
use cmf\controller\HomeBaseController;

class BusinessController extends HomeBaseController
{
    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        $service = new BusinessService();
        $pushService = new PushService();
        $businessList = $service->getBusinessList();
        $industryList = $pushService->getIndustry();
        $provinceList = $pushService->getProvinceList();

        $this->assign('businessList', $businessList['list']);
        $this->assign('page', $businessList['page']);
        $this->assign("industryList", $industryList);
        $this->assign("provinceList", $provinceList);
        return $this->fetch(':business_index');
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
}
