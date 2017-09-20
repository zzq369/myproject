<?php
/**
 * 地区控制器
 * User: admin
 * Date: 2017/9/11
 * Time: 23:26
 */

namespace app\admin\widget;

use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

class RegionWidget extends AdminBaseController
{
    /**
     * 联动生成地区select
     * @author xy
     * @since 2017/09/14 23:51
     */
    public function region_select($province = 0, $city = 0, $area = 0)
    {
        $where = [
            'id' => ['neq', 0],
            'pid' => 0,
        ];
        $provinceList = Db::name('region')->where($where)->select()->toArray();
        if (empty($provinceList)) {
            return false;
        }
        //生成 省份的select
        $html = '<select name="province" id="province" class="form-control region-select" style="width: 200px;display: inline-block">';
        $html .= '<option value="" >请选择省份</option>';
        foreach ($provinceList as $regionPro) {
            if (!empty($province) && $province == $regionPro['Id']) {
                $html .= '<option value="' . $regionPro['Id'] . '" selected="selected">' . $regionPro['name'] . '</option>';
            } else {
                $html .= '<option value="' . $regionPro['Id'] . '">' . $regionPro['name'] . '</option>';
            }

        }
        $html .= '</select>';
        $html .= '<select name="city" id="city" class="form-control region-select" style="width: 200px;display: inline-block">';
        $html .= '<option value="" >请选择城市</option>';
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
        $html .= '</select>';
        //生成区县select

        if (!empty($province) && !empty($city)) {
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
            }
        }
        $this->assign('province', $province);
        $this->assign('city', $city);
        $this->assign('area', $area);
        $this->assign('html', $html);
        return $this->fetch('widget/region/region_select');
    }

}