<?php
/**
 * 互推消息
 */
namespace app\user\controller;

use cmf\controller\UserBaseController;

class PushController extends UserBaseController
{
    //列表
    public function lists(){

    }
    //添加
    public function add(){
        if($this->request->isPost()){

        }else{
            return $this->fetch("add");
        }
    }

}
