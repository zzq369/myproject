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
namespace app\portal\controller;

use app\portal\service\IndexService;
use cmf\controller\HomeBaseController;

class IndexController extends HomeBaseController
{
    public function index()
    {
        $indexService = new IndexService();
        $topPushList = $indexService->getTopPush();
        //文章列表
        $portalList = $indexService->getRecommendPortal();
        //首页banner
        $bannerList = $indexService->getBanner();

        $this->assign('topPushList', $topPushList);
        $this->assign('portalList', $portalList);
        $this->assign('bannerList', $bannerList);
        return $this->fetch(':index');
    }
}
