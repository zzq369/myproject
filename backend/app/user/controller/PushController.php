<?php
/**
 * 互推消息
 */
namespace app\user\controller;

use app\portal\model\PushTagsModel;
use think\Validate;
use app\grab\model\PushModel;
use app\user\model\RegionModel;
use cmf\controller\UserBaseController;

class PushController extends UserBaseController
{
    //列表
    public function lists(){
        $pushModel = new PushModel();
        $params = array(
            'user_id' => session("user.id"),
            'status' => 0
        );
        $field = "a.id,a.title,a.create_time,a.is_top,a.is_anxious,a.read_count,a.address,a.status,b.name as cate_name,p.name as province,c.name as city,ar.name as area";
        $result = $pushModel->getListBy($params,$field,10);
        $list = $result->items();
        if($list){
            $tagsModel = new PushTagsModel();
            foreach($list as $key=>&$val){
                //获取标签
                $paramsTags = array(
                    'push_id' => $val['id']
                );
                $tagsList = $tagsModel->getListBy($paramsTags);
                $val['tags'] = $tagsList;
                $list[$key] = $val;
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
                'charge'     => 'number|between:0,1',
                'resource_type'     => 'number|between:1,2',
                'start_time'   => 'dateFormat:Y-m-d H:i:s',
                'end_time'   => 'dateFormat:Y-m-d H:i:s',
                'business_offer' => 'require',
            ]);
            $validate->message([
                'title.require' => '标题不能为空',
                'title.chsDash' => '标题只能是汉字、字母、数字和下划线_及破折号-',
                'title.max' => '标题最大长度为32个字符',
                'charge.number' => '请选择收费方式',
                'resource_type.number' => '请选择资源类型',
                'start_time.dateFormat' => '活动开始时间格式不正确',
                'end_time.dateFormat' => '活动结束时间格式不正确',
                'business_offer.require' => '我提供的支持不能为空',
            ]);

            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $pushModel = new PushModel();
            if ($pushModel->savePush($data)) {
                $this->success("保存成功！", "User/Push/lists");
            } else {
                $this->error("没有新的修改信息！");
            }
        }else{
            //地区
            $regionModel = new RegionModel();
            $params['pid'] = 0;
            $proviceList = $regionModel->getListsBy($params);
            $info = array(
                'id' => '',
                'title' => '',
                'resource_type' => '',
                'charge' => '',
                'start_time' => now_time(),
                'end_time' => now_time(),
                'business_offer' => '',
                'support' => '',
                'province' => '',
                'city' => '',
                'area' => ''
            );
            $id = $this->request->get("id");
            if($id){
                $pushModel = new PushModel();
                $info = $pushModel->getInfoById($id);
            }

            $this->assign('info', $info);
            $this->assign("proviceList", $proviceList);
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
            $newData = array(
                'id'=> $data['id'],
                'status' => 2
            );
            $pushModel = new PushModel();
            if ($pushModel->savePush($newData)) {
                $this->success("删除成功！", "User/Push/lists");
            } else {
                $this->error("删除失败！");
            }
        }
    }

}
