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
        ini_set('memory_limit', '500M');
        ini_set('display_errors','on');
        error_reporting(E_ALL);
        $cate = $_GET['cate'];
        if(!$cate){
            echo "请输入类型";
            die;
        }
        $cate_list = array(
            1=>4,2=>5,3=>2,4=>3,5=>1,6=>10,7=>6,8=>7,9=>8,10=>9
        );
        $category_id = $cate_list[$cate];
        ini_set("memory_limit", '128M');
        for($p = 1; $p<=70; $p++){
            $url = 'http://www.admaimai.com/shop/l'.$cate.'a0c0kp'.$p.'.html';
            if(empty($url)){
                echo "请输入URL";
                die;
            }
            echo $url."<br />";
            ob_flush();
            flush();
            vendor('simple_html_dom');
            try {
                $html = file_get_html($url);
                $comList = $html->find(".sh16_wid02 .sh16_m02_1");
                foreach ($comList as $key => $dom) {
                    echo "run compan list ----" . $key . '<br>';
                    ob_flush();
                    flush();
                    $href_list = $dom->find(".sh16_m02_2 .sh16_lf a", 0)->href;
                    $this->runList($href_list, $category_id);
                    unset($href_list);
                }
                unset($comList, $html, $url);
            }catch (Exception $e){
                continue;
            }
        }
    }

    public function runList($url,$category_id){
        $url = 'http://www.admaimai.com'.$url;
        echo "run company info----" . $url .'<br>';
        ob_flush();
        flush();
        try {
            $html = file_get_html($url);
            $adList = $html->find(".zxt_04f2");
            foreach ($adList as $key => $dom) {
                //判断是否可抓取内容
                echo "run ad list----" . $key . '<br>';
                ob_flush();
                flush();
                $href_ad = $dom->find(".z_zy_v3 .z_f3", 0)->href;
                echo "run ad href----" . $href_ad . '<br>';
                $this->adInfo($href_ad, $category_id);
                unset($href_ad, $dom);
            }
            unset($adList, $html, $url);
        }catch (Exception $e){
            return true;
        }
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

    public function adInfo($url,$category_id){
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
            //判断title是否已存在
            $pushModel = new PushModel();
            $pushInfo = $pushModel->getInfoByTitle($title);
            if($pushInfo){
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
            if(empty($type_tr)){
                $type_tr = $html->find(".z_h_12b1_xmt tr", 1);
            }
            if(empty($type_tr)){
                return true;
            }
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
            $data['category_id'] = $category_id;
            $pushModel->insertGetId($data);
            unset($html, $title, $company_name, $type, $tel, $address, $content);
            return true;
        }catch (Exception $e){
            return true;
        }
    }
}
