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

use think\Db;
use think\Model;

class ActivityModel extends Model
{
    /**
     * 根据主键获取会员发布的活动
     * @author xy
     * @since 2017/11/19 16:51
     * @param int $activityId 活动id
     * @return array|bool|false|\PDOStatement|string|Model
     */
    public function getActivityByPk($activityId){
        $query = Db::name('activity');
        $activity = $query->where(['activity_id' => $activityId])->find();
        if($activity){
            return $activity;
        }
        return false;
    }

    public function saveActivity($data){
        $query = Db::name('activity');
        $data['content'] = htmlspecialchars($data['content']);
        if(!empty($data['activity_id'])){
            $activity = $this->getActivityByPk($data['activity_id']);
            if($activity['user_id'] != session('user.id')){
                $this->error = '修改的活动不属于当前会员';
                return false;
            }
            $data['update_time'] = now_time();
            $result = $query->where(['activity_id' => $data['activity_id']])->update($data);
        }else{
            $data['create_time'] = now_time();
            $result = $query->insertGetId($data);
        }
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}