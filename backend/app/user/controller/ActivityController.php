<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/19
 * Time: 16:34
 */

namespace app\user\controller;


use app\user\model\ActivityModel;
use cmf\controller\UserBaseController;
use think\Request;
use think\Validate;

class ActivityController extends UserBaseController
{
    public function activity_list(){

    }
    public function add(){
        if(Request::instance()->isAjax()){
            $validate = new Validate([
                'title' => 'require|chsDash|max:100',
                'start_time'   => 'dateFormat:Y-m-d H:i:s',
                'end_time'   => 'dateFormat:Y-m-d H:i:s',
                'content' => 'require',
                'image' => 'require'
            ]);
            $validate->message([
                'title.require' => '标题不能为空',
                'title.chsDash' => '标题只能是汉字、字母、数字和下划线_及破折号-',
                'title.max' => '标题最大长度为32个字符',
                'start_time.dateFormat' => '活动开始时间格式不正确',
                'end_time.dateFormat' => '活动结束时间格式不正确',
                'content.require' => '活动内容不能为空',
                'image.require' => '请上传活动图片',
            ]);
            $data = $this->request->post();
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $activityModel = new ActivityModel();
            if(!$activityModel->saveActivity($data)){
                $this->error($activityModel->getError());
            }
            $this->success('添加成功');
        }else{
            $activity = [
                'activity_id' => '',
                'title' => '',
                'start_time' => now_time(),
                'end_time' => now_time(),
                'content' => '',
                'image' => '',
            ];
            $activityId = input('param.activity_id', 0, 'intval');
            if($activityId){
                $activityModel = new ActivityModel();
                $activity = $activityModel->getActivityByPk($activityId);
                if(!$activity){
                    $this->error('未找到对应的数据');
                }
                if($activity['user_id'] != session('user.id')){
                    $this->error('此活动不属于当前会员');
                }
            }
            $this->assign([
                'activity' => $activity,
            ]);
            return $this->fetch('add');
        }
    }

    public function delete(){
        $activityId = input('param.activity_id', 0, 'intval');
        if($activityId){
            $activityModel = new ActivityModel();
            $activity = $activityModel->getActivityByPk($activityId);
            if(!$activity){
                $this->error('未找到对应的数据');
            }
            if($activity['user_id'] != session('user.id')){
                $this->error('此活动不属于当前会员');
            }
            $data['is_delete'] = 1;
            $result = $activity->save($data);
            if($result){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else {
            $this->error('参数错误');
        }
    }

    public function show(){
        $activityId = input('param.activity_id', 0, 'intval');
        if($activityId){
            $activityModel = new ActivityModel();
            $activity = $activityModel->getActivityByPk($activityId);
            if(!$activity){
                $this->error('未找到对应的数据');
            }
            if($activity['user_id'] != session('user.id')){
                $this->error('此活动不属于当前会员');
            }
            if($activity['is_show'] == 1){
                $data['is_show'] = 0;
                $message = '下架成功';
            }else {
                $data['is_show'] = 1;
                $message = '发布成功';
            }
            $result = $activity->save($data);
            if($result){
                $this->success($message);
            }else{
                $this->error('操作失败');
            }
        }else {
            $this->error('参数错误');
        }
    }
}