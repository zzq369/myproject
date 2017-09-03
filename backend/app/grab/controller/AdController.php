<?php
/**
 * 抓取程序
 * url: http://www.admaimai.com
 */
namespace app\grab\controller;

use app\grab\model\PushCategoryModel;
use app\grab\model\PushModel;
use cmf\controller\BaseController;
use think\Db;
use think\Exception;

class AdController extends BaseController
{

    /**
     * 抓取程序run
     */
    public function run(){
        set_time_limit(0);
        ini_set("memory_limit", '128M');
        for($p = 1; $p<=70; $p++){
            $url = 'http://www.admaimai.com/shop/l5a0c0kp'.$p.'.html';
            if(empty($url)){
                echo "请输入URL";
                die;
            }
            echo $url."<br />";
            ob_flush();
            flush();
            vendor('simple_html_dom');
            $html = file_get_html($url);
            $comList = $html->find(".sh16_wid02 .sh16_m02_1");
            foreach($comList as $key=>$dom){
                echo "run compan list ----" . $key .'<br>';
                ob_flush();
                flush();
                $href_list = $dom->find(".sh16_m02_2 .sh16_lf a", 0)->href;
                $this->runList($href_list);
                unset($href_list);
            }
            unset($comList,$html,$url);
        }
    }

    public function runList($url){
        $url = 'http://www.admaimai.com'.$url;
        echo "run company info----" . $url .'<br>';
        ob_flush();
        flush();
        $html = file_get_html($url);
        $adList = $html->find(".zxt_04f2");
        foreach($adList as $key=>$dom){
            //判断是否可抓取内容
            echo "run ad list----" . $key .'<br>';
            ob_flush();
            flush();
            $href_ad = $dom->find(".z_zy_v3 .z_f3", 0)->href;
            echo "run ad href----" . $href_ad .'<br>';
            $this->adInfo($href_ad);
            unset($href_ad, $dom);
        }
        unset($adList, $html, $url);
    }

    public function runCategory(){
        $arr = ['户外','电视','广播','报纸','杂志','制作','策划','设备','材料','新兴'];
        $adcModel = new PushCategoryModel();
        $data = [];
        foreach($arr as $v){
            $data[] = array(
                'name' => $v,
                'create_time' => now_time(),
                'update_time' => now_time()
            );
        }
        $adcModel->insertAll($data);
    }

    public function adInfo($url){
        try {
            $url = 'http://www.admaimai.com' . $url;
            echo "----" . $url . '<br>';
            ob_flush();
            flush();
            $html = file_get_html($url);
            $can_push = $html->find(".zxt_03b", 0);
            $attr = $can_push->attr;
            if (!isset($attr['style'])) {
                return false;
            }

            //公司名称
            $company_name = $html->find(".zxt_01 .z_f3", 1);
            $company_name = $company_name->plaintext;
            //标题
            $title = $html->find(".zxt_04f1_zy", 0);
            $title = $title->plaintext;
            if (empty($title)) {
                return false;
            }
            //地区
            $provice = $html->find(".t_lf .z_f3", 0);
            $provice = $provice->plaintext;
            $city = $html->find(".t_lf .z_f3", 1);
            $city = $city->plaintext;
            $address = $provice . " " . $city;

            //类型
            $type_tr = $html->find(".z_h_12b1 tr", 1);
            $type_list = $type_tr->find(".z_f3");
            $type = [];
            foreach ($type_list as $val) {
                $type_one = $val->plaintext;
                $type[] = $type_one;
            }
            $type = implode(",", $type);

            //电话
            $tel_info = $html->find(".z_h_12g .z_f5", 0);
            $tel = $tel_info->plaintext;
            //内容
            $content_info = $html->find(".zxt_04f3_zy", 0);
            $content = $content_info->innertext;
            $data = [];
            $data['user_id'] = 2;
            $data['title'] = $title;
            $data['company_name'] = $company_name;
            $data['type'] = $type;
            $data['tel'] = $tel;
            $data['address'] = $address;
            $data['business_offer'] = $content;
            $data['category_id'] = 1;
            $pushModel = new PushModel();
            $pushModel->insertGetId($data);
            unset($html, $title, $company_name, $type, $tel, $address, $content);
            return true;
        }catch (Exception $e){
            return true;
        }
    }
}
