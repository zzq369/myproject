<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:kane < chengjin005@163.com>
// +----------------------------------------------------------------------
namespace app\portal\model;

use think\Model;

class PortalTagModel extends Model
{
    public static   $STATUS = array(
        0=>"未启用",
        1=>"已启用",
    );

    /**
     * 获取可以使用的文章标签
     * @author xy
     * @since 2017/10/24 18:55
     * @return array|bool
     */
    public function getCanUseTags(){
        $where = [
            'status' => 1
        ];
        $array = $this->field('*, id as key, name as label')->where($where)->select()->toArray();
        if(count($array) > 0){
            return $array;
        }
        return false;
    }
}