<?php
/**
 * 抓取程序
 */
namespace app\grab\controller;

use cmf\controller\BaseController;
use think\Db;

class IndexController extends BaseController
{

    /**
     * 抓取程序run
     */
    public function run(){
        $url = 'http://www.bdwork.com/forum-40-1.html';
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
        $list = $html->find("#moderate ul li[id^='normalthread_'] .xst");
        foreach($list as $v){
            $href = $v->href; //获取列表里面各详情页的链接
            $href = 'http://www.bdwork.com/'.$href;
            $this->run_info($href);
            die;
        }


        $title = $html->find('#thread_subject',0);
        $t = $title->plaintext;
        $t = iconv("UTF-8", "GB2312//IGNORE", $t) ;
        echo $t;die;
    }

    /**
     * 跑详情数据
     */
    private function run_info($url){
        vendor('simple_html_dom');
        $html = file_get_html($url);
        $info = [];
        $title = $html->find("#thread_subject", 1);
        $title = $title->plaintext;
        $title = iconv("UTF-8", "GB2312//IGNORE", $title) ;
        $info['title'] = $title;
        $param = $html->find('.sort_thread dl');
        foreach($param as $key=>$val){
            $dt = $val->find("dt", 0);
            $d_title = iconv("UTF-8", "GB2312//IGNORE", $dt->plaintext) ;
            $dd = $val->find('dd', 0);
            $dd_title = iconv("UTF-8", "GB2312//IGNORE", $dd->plaintext) ;
            echo $dd_title;
        }
        die;
    }
    public function test()
    {
        $url = I('get.url');
        $url = trim($url);
        if(!strstr($url,'https://') && !strstr($url,'http://')){
            $url = 'https://' . $url;
        }
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER,false);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST,false);
        $curl->setHeader('user-agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36');
        $curl->setHeader('accept-language','zh-CN,zh;q=0.8,en;q=0.6');
        $data = $curl->get($url);
        if(!$data){
            $this->ajaxReturn(['error' => 'globalsources禁止了该产品的公开查看']);
        }
        vendor('simple_html_dom');
        $document = str_get_html($data);

        // $document = new Document($data);
        $rs = array();

        //标题title
//        $title = $document->find('.proFullName');
//        $title = count($title) > 0 ? $title[0] : '';
//        $rs['title'] = $title ? trim($title->text()) : '';
        $title = $document->find('.pp_con_detail h1', 0);
        if ($title) {
            $title->find('.pp_newTag', 0)->outertext = '';
            $title = trim($title->innertext);
        }
        $rs['title'] = $title;
        if(!$rs['title']){
            $this->ajaxReturn(['error' => '无法同步该页面的产品数据']);
        }

        $keys = $document->find('.pp_mInfo .mr10'); //获取属性参数名
        $values = $document->find('.pp_mInfo .pp_mTag'); //获取属性参数值
        $lastKey = '';
        for($i = 0;$i<count($keys) ; $i++){
            $k = $keys[$i];
            $k = $k->innertext;
            $v = $values[$i];

            if(!$k){
                $rs[$lastKey] .= (' ' . $v->innertext);
                continue;
            }

            if($k == 'Min. Order:'){
                $rs['min_order_quantity'] = $v->innertext;
                $lastKey = $k;
            }else if($k == 'Production Capacity:'){
                $rs['supply_ability'] = $v->innertext;
                $lastKey = $k;
            }else if($k == 'FOB Port:'){
                $rs['port'] = $v->innertext;
                $lastKey = $k;
            }else if($k == 'Payment Method:'){
                $rs['payment_terms'] = $v->innertext;
                $lastKey = $k;
            }else if($k == 'FOB Price:'){
                //价格
                $rs['price'] = $v->innertext;
                $lastKey = $k;
            }else{
                //多余的属性当参数处理
                $rs['attr'][$k] = $v->innertext;
            }
        }
        $price = $document->find('.pp_mFOB em', 0);
        if ($price) {
            $rs['price'] = trim($price->innertext);
        }
        $detail = $document->find('.pp_section .pp_secCon', 0);
        $rs['content'] = $detail ? $detail->innertext : '';

        $img = $document->find('.img_frame_con img');
        if(count($img) > 0){
            foreach ($img as $i){
                $rs['images'][] = $i->src;
            }
        }
        $this->ajaxReturn($rs);
    }
}
