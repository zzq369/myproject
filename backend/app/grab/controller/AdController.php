<?php
/**
 * 抓取程序
 * url: http://www.admaimai.com
 */
namespace app\grab\controller;

use app\grab\model\AdModel;
use cmf\controller\BaseController;
use think\Db;

class AdController extends BaseController
{

    /**
     * 抓取程序run
     */
    public function run(){
        $url = 'http://www.admaimai.com/Effect/Outdoor/61495.html';
        if(empty($url)){
            echo "请输入URL";
            die;
        }

        $url = trim($url);
        if(!strstr($url,'https://') && !strstr($url,'http://')){
            $url = 'https://' . $url;
        }
        vendor('simple_html_dom');
        $html = file_get_html($url);
        //公司名称
        $company_name = $html->find(".zxt_01 .z_f3", 1);
        $company_name = $company_name->plaintext;
        //标题
        $title = $html->find(".zxt_04f1_zy",0);
        $title = $title->plaintext;
        //地区
        $provice = $html->find(".t_lf .z_f3",0);
        $provice = $provice->plaintext;
        $city = $html->find(".t_lf .z_f3",1);
        $city = $city->plaintext;
        $address = $provice . " " .$city;

        //类型
        $type_tr = $html->find(".z_h_12b1 tr",1);
        $type_list = $type_tr->find(".z_f3");
        $type = [];
        foreach($type_list as $val){
            $type_one = $val->plaintext;
            $type[] = $type_one;
        }
        $type = implode(",", $type);

        //电话
        $tel_info = $html->find(".z_h_12g .z_f5", 0);
        $tel = $tel_info->plaintext;
        //内容
        $content_info = $html->find(".zxt_04f3_zy",0);
        $content = $content_info->innertext;
        $data = [];
        $data['title'] = $title;
        $data['company_name'] = $company_name;
        $data['type'] = $type;
        $data['tel'] = $tel;
        $data['address'] = $address;
        $data['content'] = $content;
        $adModel = new AdModel();
        $adModel->addAd($data);
    }
}
