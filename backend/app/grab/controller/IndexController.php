<?php
/**
 * 抓取程序
 */
namespace app\grab\controller;

use cmf\controller\BaseController;
use think\Db;
use Curl\Curl;

class IndexController extends BaseController
{

    public function index()
    {
        $url = 'http://www.bdwork.com/forum-40-1.html';
        $url = trim($url);
        if(!strstr($url,'https://') && !strstr($url,'http://')){
            $url = 'https://' . $url;
        }
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_HTTPHEADER,'\'user-agent\', \'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36\'');
        /curl_setopt($curl,CURLOPT_HTTPHEADER,'\'accept-language\',\'zh-CN,zh;q=0.8,en;q=0.6\'');
        $response = curl_exec($curl);
        $data = curl_getinfo($curl);
        print_r($data);die;
        curl_close($curl);
        if(!$data){
           echo "不存在页面";die;
        }
        vendor('simple_html_dom');
        $document = str_get_html($data);

        $rs = array();

        //标题title
        $title = $document->find('.top .top_nav strong', 0);
    }
}
