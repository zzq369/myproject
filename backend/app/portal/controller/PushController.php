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

        $this->assign('categoryList', $categoryList);
        $this->assign('pushList', $pushList);
        $this->assign("industryList", $industryList);
        return $this->fetch(':push_index');
    }
}
