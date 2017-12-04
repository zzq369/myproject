<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Powerless < wzxaini9@gmail.com>
// +----------------------------------------------------------------------
namespace app\user\model;

use think\Config;
use think\Db;
use think\Model;

class ActivityModel extends Model
{
    public function saveActivity($data){
        $query = Db::name("activity");
        $data['content'] = htmlspecialchars($data['content']);
        $data['user_id'] = session('user.id');
        $data['update_time'] = now_time();
        if($data['id']){
            $id = $data['id'];
            unset($data['user_id'],$data['id']);
            $oldData = $query->where(array('id'=>$id,'user_id'=>session('user.id')))->field('image')->find();
            //上传的图片与旧图片不一致，则删除旧图片
            if($oldData['image'] != $data['image']){
                unlink($this->getRealActivityImagePath($oldData['image'], true));
            }
            $query->where(array('id'=>$id,'user_id'=>session('user.id')))->update($data);
        }else{
            $data['create_time'] = now_time();
            $id = $query->insertGetId($data);
        }
        if ($id) {
            return $id;
        } else {
            return false;
        }
    }

    /**
     * title获取互推详情
     * @param $title
     * @return array|false|\PDOStatement|string|Model
     */
    public function getInfoByTitle($title){
        $query = Db::name("activity");
        $info = $query->where('title', $title)->find();
        return $info;
    }

    /**
     * id获取互推详情
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     */
    public function getInfoById($id){
        $query = Db::name("activity");
        $info = $query
            ->where('id', $id)
            ->find();
        if(!empty($info)){
            $imageRealPath = empty($info['image']) ?  '' : $this->getRealActivityImagePath($info['image']);
            $info['image_path'] = $imageRealPath == false ? '' : $imageRealPath;
        }
        return $info;
    }

    /**
     * 根据条件获取列表
     * @param $params
     */
    public function getListBy($params, $field = "*", $limit = 5){
        $query = Db::name("activity");
        $list = $query->alias("a")->field($field)
            ->where($params)->limit($limit)->order("a.update_time desc")->paginate(10);
        return $list;
    }

    /**
     * 获取活动图片的路径
     * @author xy
     * @since 2017/12/04 15:58
     * @param string $filename 文件名
     * @param bool $isReal 是否返回真实路径 true 是， false 返回相对路径
     * @return bool|string
     */
    public function getRealActivityImagePath($filename, $isReal = false){
        if(empty($filename)){
            return false;
        }
        $config = Config::get('user_activity_image');
        $dir = $config['dir'];
        $filePath = $dir . '/'. session('user.id') . '/' .$filename;
        if(file_exists($filePath)){
            if($isReal){
                return $filePath;
            }else{
                $filePath = $config['rel_dir'] . '/'. session('user.id') . '/' .$filename;
                return $filePath;
            }
        }
        return false;
    }
}

