<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/17
 * Time: 22:23
 */

namespace app\admin\controller;


use cmf\controller\AdminBaseController;
use think\Db;


class RegionController extends AdminBaseController
{
    public function get_city($province = 0)
    {
        $province = input('param.province', 0);
        $html = '<option value="" >请选择城市</option>';
        if (!empty($province)) {
            //生成城市的select
            if (!empty($province)) {
                $whereCity = [
                    'id' => ['neq', 0],
                    'pid' => $province,
                ];
                $cityList = Db::name('region')->where($whereCity)->select()->toArray();
                if (!empty($cityList)) {
                    foreach ($cityList as $regionCity) {
                        if (!empty($city) && $city == $regionCity['Id']) {
                            $html .= '<option value="' . $regionCity['Id'] . '" selected="selected">' . $regionCity['name'] . '</option>';
                        } else {
                            $html .= '<option value="' . $regionCity['Id'] . '">' . $regionCity['name'] . '</option>';
                        }

                    }
                }
            }
        }
        echo json_encode($html);
    }

    public function get_area()
    {
        $city = input('param.city', 0);
        $html = '';
        $city = intval($city);
        if (!empty($city)) {
            $whereArea = [
                'id' => ['neq', 0],
                'pid' => $city,
            ];
            $areaList = Db::name('region')->where($whereArea)->select()->toArray();
            if (!empty($areaList)) {
                $html .= '<select name="area" id="area" class="form-control region-select" style="width: 200px;display: inline-block">';
                $html .= '<option value="" >请选择城市</option>';
                foreach ($areaList as $regionArea) {
                    if (!empty($area) && $area == $regionArea['Id']) {
                        $html .= '<option value="' . $regionArea['Id'] . '" selected="selected">' . $regionArea['name'] . '</option>';
                    } else {
                        $html .= '<option value="' . $regionArea['Id'] . '">' . $regionArea['name'] . '</option>';
                    }

                }
                $html .= '</select>';
            }else{
                $html = '';
            }
        }
        echo json_encode($html);
    }
}