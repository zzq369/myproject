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
namespace app\user\controller;

use app\portal\model\UserIndustryModel;
use app\user\model\RegionModel;
use app\user\model\UserModel;
use cmf\controller\UserBaseController;
use think\Db;

class IndexController extends UserBaseController
{

    /**
     * 前台用户首页(公开)
     */
    public function index()
    {
        $user = session('user');
        $this->assign("user", $user);
        return $this->fetch(":index");

    }

    /**
     * 前台ajax 判断用户登录状态接口
     */
    function isLogin()
    {
        if (cmf_is_user_login()) {
            $this->success("用户已登录",null,['user'=>cmf_get_current_user()]);
        } else {
            $this->error("此用户未登录!");
        }
    }

    /**
     * 退出登录
    */
    public function logout()
    {
        session("user", null);//只有前台用户退出
        return redirect($this->request->root() . "/");
    }

    /**
     * 后台首页
     */
    public function main(){

        return $this->fetch(":main");
    }
    //用户详情
    public function info(){
        $user = session('user');
        $userModel = new UserModel();
        $userInfo = $userModel->getInfoById($user['id']);
        //行业
        $industryModel = new UserIndustryModel();
        $industryList = $industryModel->getList(['status'=>1]);
        //地区
        $regionModel = new RegionModel();
        $params['pid'] = 0;
        $proviceList = $regionModel->getListsBy($params);

        //规模
        $scaleList = $userModel->scale;

        $this->assign('scaleList', $scaleList);
        $this->assign("proviceList", $proviceList);
        $this->assign("industryList", $industryList);
        $this->assign("user", $userInfo);
        return $this->fetch(":info");
    }

    //获取下级地区
    public function getNextRegion(){
        $pid = $this->request->get('pid');
        if(empty($pid))
            $this->error("参数不正确");

        $regionModel = new RegionModel();
        $params['pid'] = $pid;
        $regionList = $regionModel->getListsBy($params);
        $this->result($regionList);
    }

}
