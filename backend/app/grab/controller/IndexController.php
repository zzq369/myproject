<?php
/**
 * 抓取程序
 */
namespace app\grab\controller;

use cmf\controller\BaseController;
use think\Db;

class IndexController extends BaseController
{

    public function index()
    {
        $url = 'http://www.bdwork.com/thread-69731-1-1.html';
        $url = trim($url);
        if(!strstr($url,'https://') && !strstr($url,'http://')){
            $url = 'https://' . $url;
        }

        vendor('simple_html_dom');
        $html = file_get_html($url);
        $title = $html->find('#thread_subject',0);
        $t = $title->plaintext;
        $t = iconv("UTF-8", "GB2312//IGNORE", $t) ;
        echo $t;die;
        foreach($title as $val){
            echo $val->plaintext;
        }
        die;
        dump($title);die;

        //获取所有的img元素
        foreach($html->find('img') as $element)
            echo $element->src . '<br>';
        die;
        if(!$html){
           echo "不存在页面";die;
        }

    }
}
