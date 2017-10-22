<?php
/**
 *  商家service
 */

namespace app\portal\service;


use app\user\model\UserModel;

class BusinessService
{
    /**
     * 获取商家列表
     * @return array
     */
    public function getBusinessList(){
        $params = array(
            'a.user_status' => 1,
            'a.user_type' => array('neq', 1)
        );
        $userModel = new UserModel();
        $result = $userModel->getListBy($params);
        $list = $result->items();

        return array("list" => $list, "page" => $result->render());
    }
}