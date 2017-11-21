<?php
/**
 * 商家活动
 */
namespace app\user\controller;

use app\user\model\ActivityModel;
use think\Validate;
use cmf\controller\UserBaseController;

class ActivityController extends UserBaseController
{
    //列表
    public function lists(){
        $pushModel = new ActivityModel();
        $params = array(
            'user_id' => session("user.id"),
            'status' => 0
        );
        $field = "a.*";
        $result = $pushModel->getListBy($params,$field,10);
        $list = $result->items();
        $now = time();
        if(!empty($list)){
            foreach ($list as &$activity){
                if($activity['is_publish']){
                    if($now < strtotime($activity['start_time'])){
                        $activity['activity_status'] = '未开始';
                    }else if($now >= strtotime($activity['start_time']) && $now < ( strtotime($activity['end_time']) + 86400) ) {
                        $activity['activity_status'] = '进行中';
                    }else{
                        $activity['activity_status'] = '已结束';
                    }
                }else{
                    $activity['activity_status'] = '已下架';
                }
            }
        }
        $this->assign('list', $list);
        $this->assign('page', $result->render());
        return $this->fetch("list");
    }
    //添加
    public function add(){
        if($this->request->isPost()){
            $validate = new Validate([
                'title' => 'require|chsDash|max:200',
                'start_time'   => 'dateFormat:Y-m-d',
                'end_time'   => 'dateFormat:Y-m-d',
                'content' => 'require',
            ]);
            $validate->message([
                'title.require' => '标题不能为空',
                'title.chsDash' => '标题只能是汉字、字母、数字和下划线_及破折号-',
                'title.max' => '标题最大长度为32个字符',
                'start_time.dateFormat' => '活动开始时间格式不正确',
                'end_time.dateFormat' => '活动结束时间格式不正确',
                'content.require' => '活动规则不能为空',
            ]);

            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $activityModel = new ActivityModel();
            if ($activityModel->saveActivity($data)) {
                $this->success("保存成功！", "user/Activity/lists");
            } else {
                $this->error("没有新的修改信息！");
            }
        }else{
            $info = array(
                'id' => '',
                'title' => '',
                'start_time' => date("Y-m-d"),
                'end_time' => date("Y-m-d"),
                'content' => ''
            );
            $id = $this->request->get("id");
            if($id){
                $activityModel = new ActivityModel();
                $info = $activityModel->getInfoById($id);
            }

            $this->assign('info', $info);
            return $this->fetch("add");
        }
    }

    //删除
    public function delete(){
        if ($this->request->isPost()) {
            $validate = new Validate([
                'id' => 'require',
            ]);
            $validate->message([
                'id.require' => '参数非法'
            ]);
            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $activityModel = new ActivityModel();
            $activity = $activityModel->getInfoById($data['id']);
            if($activity['user_id'] != session('user.id')){
                $this->error('此活动不属于当前会员');
            }
            $newData = array(
                'id'=> $data['id'],
                'status' => 2
            );
            if ($activityModel->saveActivity($newData)) {
                $this->success("删除成功！", "user/Activity/lists");
            } else {
                $this->error("删除失败！");
            }
        }
    }

    /**
     * 发布或下架活动
     */
    public function publish(){
        $activityId = input('param.id', 0, 'intval');
        if($activityId){
            $activityModel = new ActivityModel();
            $activity = $activityModel->getInfoById($activityId);
            if(!$activity){
                $this->error('未找到对应的数据');
            }

            if($activity['user_id'] != session('user.id')){
                $this->error('此活动不属于当前会员');
            }
            $data['id'] = $activityId;
            if($activity['is_publish'] == 1){
                $data['is_publish'] = 0;
                $message = '下架成功';
            }else {
                $data['is_publish'] = 1;
                $message = '发布成功';
            }
            $result = $activityModel->saveActivity($data);
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
