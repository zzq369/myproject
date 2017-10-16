<?php
/**
 * 互推页面
 */
namespace app\portal\controller;

use app\portal\service\PushService;
use cmf\controller\HomeBaseController;

class PushController extends HomeBaseController
{
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
}
