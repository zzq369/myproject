<?php
/**
 * 抓取程序  微信公众号
 * url: http://www.rengzan.com
 */
namespace app\grab\controller;

use app\grab\model\PushCategoryModel;
use app\grab\model\PushModel;
use app\grab\model\WechatCategoryModel;
use app\grab\model\WechatModel;
use cmf\controller\BaseController;
use think\Db;
use think\Exception;

class WechatController extends BaseController
{

    /**
     * 抓取程序run
     */
    public function run(){
        header("Content-type: text/html; charset=utf-8");
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        ini_set('display_errors','on');
        error_reporting(E_ALL);

        $url = 'http://www.rengzan.com/';
        vendor('simple_html_dom');
        //获取分类列表
        $m_cate = new WechatCategoryModel();
        $cate_list = $m_cate->field("id,name")->select();
        $new_cate_list = array();
        foreach($cate_list as $v_c){
            $new_cate_list[$v_c['name']] = $v_c['id'];
        }
        try {
            $html = file_get_html($url);
            $cateList = $html->find(".introc .items");
            foreach ($cateList as $key => $dom) {
                echo "run cate list ----" . $key . "\r\n";
                ob_flush();
                flush();
                $href_list = $dom->find("a");
                foreach($href_list as $v){
                    $cate_name = $v->find("h3",0)->plaintext;
                    $this->runList($v->href, $new_cate_list[$cate_name]);
                }
                unset($href_list);
            }
            unset($cateList);
        }catch (Exception $e){
            return;
        }
    }
    //分类列表数据
    public function runList($url, $cate_id){
        $url = 'http://www.rengzan.com'. $url;
        $html = file_get_html($url);

        $list = $html->find(".resourcese .author-item-li");
        foreach($list as $key=>$dom){
            try {
                $info = $dom->find(".author-info .author-pic a", 0);
                $href = $info->href;
                echo "wechat info href ---" . $href . "\r\n";
                ob_flush();
                flush();
                $this->runInfo($href, $cate_id);
                unset($dom);
            }catch (Exception $e){
                continue;
            }
        }
        unset($list, $url);
        //判断是否有下一页
        $page = $html->find(".pagewx a", -1);
        if($page->plaintext == '末页'){
            $page = $html->find(".pagewx a", -2);
            if($page->plaintext == '下一页'){
                $url = $page->href;
                $this->runList($url, $cate_id);
            }
        }elseif($page->plaintext == '下一页'){
            $url = $page->href;
            $this->runList($url, $cate_id);
        }
        return true;
    }
    //详情添加
    public function runInfo($url, $cate_id){
        $url = 'http://www.rengzan.com'. $url;
        try {
            $html = file_get_html($url);
            $addData = array();
            $name_html = $html->find(".main_case .wrap .cont_box h1", 0);
            if ($name_html->find("img")) {
                $addData['is_v'] = 1;
            }
            unset($name_html);
            $addData['wechat_category'] = $cate_id;

            $li_html = $html->find(".main_case .wrap .cont ul li");
            foreach ($li_html as $k => $dom) {
                $label = $dom->find("label", 0)->plaintext;
                $label = trim($label);
                $dom->find("label", 0)->outertext = '';
                $c = trim($dom->innertext);
                if ($label == '微信名称：') {
                    $addData['wechat_name'] = $c;
                }
                if ($label == '微信帐号：') {
                    $addData['wechat_account'] = $c;
                }
                if ($label == '所在地区：') {
                    $addData['address'] = $c;
                }
                if ($label == '标签tag：') {
                    $addData['tag'] = $dom->find("a", 0)->plaintext;
                }
                if ($label == '客服QQ：') {
                    $addData['qq'] = $c;
                }
            }
            $addData['add_time'] = now_time();
            unset($li_html);
            $view_html = $html->find(".main_case .wrap .viewcewc .info");
            foreach ($view_html as $k => $vv) {
                $count = $vv->find("i", 0)->plaintext;
                if ($k == 0) {
                    $addData['like'] = $count;
                }
                if ($k == 1) {
                    $addData['fans'] = $count;
                }
            }
            unset($view_html);
            $qrcode_html = $html->find(".main_case .wrap .cont_cat img", 0);
            $qr_code = $qrcode_html->src;
            $addData['qr_code'] = $qr_code;
            $m_wechat = new WechatModel();
            $m_wechat->insert($addData);
            echo "add: " . $addData['wechat_name'] . "\r\n";
            ob_flush();
            flush();
            unset($html, $addData);
        }catch (Exception $e){
            return true;
        }
    }

    public function runCate(){
        header("Content-type: text/html; charset=utf-8");
        $url = 'http://www.rengzan.com/';
        vendor('simple_html_dom');
        try {
            $html = file_get_html($url);
            $cateList = $html->find(".introc .items");
            $addCates = array();
            foreach ($cateList as $key => $dom) {
                echo "run compan list ----" . $key . '<br>';
                ob_flush();
                flush();
                $href_list = $dom->find("a");
                foreach($href_list as $v){
                    $info = $v->find(".innerd h3", 0);
                    $name = $info->plaintext;
                    echo "run name ---" . $name . '<br>';
                    ob_flush();
                    flush();
                    $addCates[] = array(
                        'name' => trim($name),
                        'add_time' => now_time(),
                        'level' => 1,
                        'parent_id' => 0
                    );
                }
                unset($href_list);
            }
            $m = new WechatCategoryModel();
            $m->insertAll($addCates);
            unset($cateList);
        }catch (Exception $e){
            return;
        }
    }

}
