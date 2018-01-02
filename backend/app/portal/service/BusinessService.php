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
        if (isset($_GET['industry_id']) && $_GET['industry_id'] != -1) {
            $params['ui.industry_id'] = $_GET['industry_id'];
        }
        if (isset($_GET['provice_id']) && $_GET['provice_id'] != -1) {
            $params['ui.provice_id'] = $_GET['provice_id'];
        }
        if (isset($_GET['scale']) && $_GET['scale'] != -1) {
            $params['ui.scale'] = $_GET['scale'];
        }
        $userModel = new UserModel();
        $result = $userModel->getListBy($params);
        $list = $result->items();
        $scaleList = $userModel->scale;
        foreach ($list as &$val) {
            $val['scale'] = $scaleList[$val['scale']];
        }

        return array("list" => $list, "page" => $result->render());
    }
}