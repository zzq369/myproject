<?php
/**
 * 商家互推后台控制器
 * User: admin
 * Date: 2017/9/11
 * Time: 23:26
 */

namespace app\admin\controller;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

class PushController extends AdminBaseController
{
    /**
     * 商家互推列表
     * @author xy
     * @since 2017/09/11 23:28
     */
    public function index(){
        $request = input('request.');
        $pushQuery = Db::name('push');
        $where = [];
        if(!empty($request['title'])){
            $where['title'] = ['like', '%'.$request['title'].'%'];
        }
        if(!empty($request['company_name'])){
            $where['company_name'] = ['like', '%'.$request['company_name'].'%'];
        }
        if(!empty($request['category_id'])){
            $where['category_id'] = $request['category_id'];
        }
        if(!empty($request['resource_type'])){
            $where['resource_type'] = $request['resource_type'];
        }
        $list = $pushQuery->where($where)->paginate(15);
        // 获取分页显示
        $page = $list->render();

        $category = Db::name('push_category')->field('id, name')->select();
        $category = !empty($category) ? $category->toArray() : '';
        $newCategory = [];
        foreach ($category as $val){
            $newCategory[$val['id']] = $val['name'];
        }

        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('newCategory', $newCategory);

        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 商家互推消息编辑
     * @author xy
     * @since 2017/09/13 23:41
     * @return mixed
     */
    public function edit(){
        $id = input('param.id', 0);
        if(Request::instance()->isAjax()){
            if(empty($id)){
                $this->error('必填参数缺失');
            }
            $editData = $this->request->post();
            $editData['update_time'] = date('Y-m-d H:i:s', time());
            //新添加的类型
            $insertTypeData = array();
            if(!empty($editData['new_type_name'])){
                $typeArr = explode(',',$editData['new_type_name']) ;
                foreach ($typeArr as $tKey => $type){
                    $insertTypeData[$tKey]['name'] = $type;
                    $insertTypeData[$tKey]['create_time'] = date('Y-m-d H:i:s', time());
                    $insertTypeData[$tKey]['push_id'] = $id;
                }
            }
            //删除的类型
            if(!empty($editData['del_type_id'])){
                $delTypeIdArr = explode(',',$editData['del_type_id']) ;
            }
            $insertTagData = array();
            if(!empty($editData['new_tag_name'])){
                $tegArr = explode(',',$editData['new_tag_name']) ;
                foreach ($tegArr as $gKey => $tag){
                    $insertTagData[$gKey]['name'] = $tag;
                    $insertTagData[$gKey]['create_time'] = date('Y-m-d H:i:s', time());
                    $insertTagData[$gKey]['push_id'] = $id;
                }
            }
            if(!empty($editData['del_tag_id'])){
                $delTagIdArr = explode(',',$editData['del_tag_id']) ;
            }
            unset($editData['new_tag_name'],$editData['del_type_id'],$editData['new_type_name'],$editData['del_tag_id']);
            Db::startTrans();
            $result = Db::name('push')->where(['id' => $id])->update($editData);

            if($result){
                if(!empty($insertTypeData)){
                    $result = Db::name('push_type')->insertAll($insertTypeData);
                    if(!$result){
                        Db::rollback();
                    }
                }
                if(!empty($insertTagData)){
                    $result = Db::name('push_tags')->insertAll($insertTagData);
                    if(!$result){
                        Db::rollback();
                    }
                }
                if(!empty($delTypeIdArr)){
                    foreach ($delTypeIdArr as $typeId){
                        $result = Db::name('push_type')->where(['id' => $typeId])->delete();
                        if($result === false){
                            Db::rollback();
                        }
                    }
                }
                if(!empty($delTagIdArr)){
                    foreach ($delTagIdArr as $tagId){
                        $result = Db::name('push_tags')->where(['id' => $tagId])->delete();
                        if($result === false){
                            Db::rollback();
                        }
                    }
                }
                Db::commit();
                $this->success('编辑成功');
            }else{
                Db::rollback();
                $this->error('编辑失败');
            }
        }else{
            if(empty($id)){
                $this->error('必填参数缺失');
            }
            $where = [
                'p.id' => $id,
            ];
            $processPush = Db::name('push')->alias('p')->where($where)->find();
            if(empty($processPush['id'])){
                $this->error('未找到对应的数据', url('admin/push/index'));
            }
            if(empty($processPush['is_process'])){
                //处理type字段的数据
                $pushProcessData = array(
                    'is_process' => 1,
                );

                if(!empty($processPush['type'])){

                    $pTypeArr = array_unique(explode(',', $processPush['type']));
                    $pInsertTypeData = array();
                    foreach ($pTypeArr as $pKey=>$pType){
                        if(!empty($pType)){
                            $pInsertTypeData[$pKey]['name'] = $pType;
                            $pInsertTypeData[$pKey]['push_id'] = $id;
                            $pInsertTypeData[$pKey]['create_time'] = date('Y-m-d', time());
                        }
                    }
                    if(!empty($pInsertTypeData)){
                        $result = Db::name('push_type')->insertAll($pInsertTypeData);
                        if(!$result){
                            $this->error('数据处理失败');
                        }
                        $pushProcessData['type'] = '';
                    }
                }
                //处理address字段数据
                if(!empty($processPush['address'])){
                    $addressArr = explode(' ', trim($processPush['address']));
                    if(!empty($addressArr)){
                        foreach ($addressArr as $addr){
                            if(!empty($addr)){
                                $region = process_pick_region_data($addr);
                                if(!empty($region)){
                                    foreach ($region as $rKey => $rId){
                                        $pushProcessData[$rKey] = $rId;
                                    }
                                }
                            }
                        }
                    }
                }
                if(!empty($pushProcessData)){
                    $processResult = Db::name('push')->where(['id' => $id])->update($pushProcessData);
                    if(!$processResult){
                        $this->error('数据处理失败');
                    }
                }
            }

            $push = Db::name('push')->alias('p')
                ->field(
                    'p.*, u.user_login, u.user_type, u.user_email, u.mobile, u.user_nickname,
                    GROUP_CONCAT(pt.id) as tag_ids, GROUP_CONCAT(pt.name) as tags'
                )
                ->join('__PUSH_TAGS__ pt', 'pt.push_id = p.id', 'LEFT')
                ->join('__USER__ u', 'u.id = p.user_id', 'LEFT')
                ->join('__USER_INFO__ ui', 'u.id = ui.user_id', 'LEFT')
                ->where($where)
                ->find();

            $pushType = Db::name('push_type')->alias('pt')
                ->field('GROUP_CONCAT(pt.id) as type_ids, GROUP_CONCAT(pt.name) as types')
                ->where(['push_id' => $id])
                ->find();
            $push['type_ids'] = $push['types'] = '';
            if(!empty($pushType)){
                $push['type_ids'] = $pushType['type_ids'];
                $push['types'] = $pushType['types'];
            }
            //获取互推分类数据
            $categoryList = Db::name('push_category')->select()->toArray();
            if(empty($categoryList)){
                $this->error('获取互推分类列表失败');
            }

            $this->assign('categoryList', $categoryList);
            $this->assign('push', $push);
            return $this->fetch();
        }
    }

    /**
     * 添加商家互推
     * @author xy
     * @since 2017/09/13 23:44
     * @return mixed
     */
    public function add(){
        if(Request::instance()->isAjax()){
            $insertData = $this->request->post();
            //默认已处理
            $insertData['is_process'] = 1;
            $pushTypeStr = trim($insertData['new_type_name']);
            $pushTagStr = trim($insertData['new_tag_name']);
            unset($insertData['new_type_name'],$insertData['new_tag_name']);

            // 启动事务
            Db::startTrans();
            $pushId = Db::name('push')->insertGetId($insertData);
            if(!$pushId){
                // 回滚事务
                Db::rollback();
                $this->error('添加失败');
            }else{
                if (!empty($pushTypeStr)) {
                    $pushTypeArr = explode(',', $pushTypeStr);
                    $insertTypeDate = [];
                    foreach ($pushTypeArr as $key_1 => $value_1) {
                        if(!empty($value_1)){
                            $insertTypeDate[$key_1]['push_id'] = $pushId;
                            $insertTypeDate[$key_1]['name'] = $value_1;
                            $insertTypeDate[$key_1]['create_time'] = date('Y-m-d H:i:s', time());
                        }
                    }
                    if(!empty($insertTypeDate)){
                        $result = Db::name('push_type')->insertAll($insertTypeDate);
                        if(!$result){
                            // 回滚事务
                            Db::rollback();
                            $this->error('添加失败');
                        }
                    }
                }
                if (!empty($pushTagStr)) {
                    $pusTagArr = explode(',', $pushTagStr);
                    $insertTagDate = [];
                    foreach ($pusTagArr as $key_2 => $value_2) {
                        if(!empty($value_2)){
                            $insertTagDate[$key_2]['push_id'] = $pushId;
                            $insertTagDate[$key_2]['name'] = $value_2;
                            $insertTagDate[$key_2]['create_time'] = date('Y-m-d H:i:s', time());
                        }
                    }
                    if(!empty($insertTagDate)){
                        $result = Db::name('push_tags')->insertAll($insertTagDate);
                        if(!$result){
                            // 回滚事务
                            Db::rollback();
                            $this->error('添加失败');
                        }
                    }
                }
                // 提交事务
                Db::commit();
                $this->success('添加成功');
            }
        }else{
            //获取互推分类数据
            $categoryList = Db::name('push_category')->select()->toArray();
            if(empty($categoryList)){
                $this->error('获取互推分类列表失败');
            }
            $this->assign('categoryList', $categoryList);
            return $this->fetch();
        }
    }

    /**
     * 删除商家互推信息
     * @author xy
     * @since 2017/09/13 23:47
     */
    public function delete(){
        $id = input('param.id', 0);
        if(empty($id)){
            $this->error('id参数缺失');
        }
        $result = Db::name('push')->where(['id'=>$id])->delete();
        if($result){
            $this->success('删除成功');
        } else{
            $this->error('删除失败');
        }
    }

    /**
     * 互推类型管理
     * @author xy
     * @since 2017/09/11 23:47
     */
    public function category_index(){
        $name = input('request.name', '');
        $where = [];
        if(!empty($name))
        $where = [
            'name' => ['like', '%'.$name.'%']
        ];
        $categoryQuery = Db::name('push_category');

        $list = $categoryQuery->where($where)->paginate(10);
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 互推分类添加
     * @author xy
     * @since 2017/09/12 23:20
     * @return mixed
     */
    public function category_add(){
        if(Request::instance()->isAjax()){
            $name = input('param.name', '');
            if(empty($name)){
                $this->error('请填写分类名称');
            }
            $data = [
                'name' => $name,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $result = Db::name('push_category')->insertGetId($data);
            if(empty($result)){
                $this->error('添加分类失败');
            }
            $this->success('添加成功', url('push/category_index'));
        }else{
            return $this->fetch();
        }
    }

    /**
     * 互推类型编辑
     * @author xy
     * @since 2017/09/11 23:59
     */
    public function category_edit(){
        $categoryId = input('param.id', 0);
        if(empty($categoryId)){
            $this->error('数据传入失败！');
        }
        if(Request::instance()->isAjax()){
            $categoryName = input('param.name', '');
            if(empty($categoryName)){
                $this->error('请填写分类名称！');
            }
            $data = [
                'name' => $categoryName,
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $result = Db::name('push_category')->where(['id' => $categoryId])->update($data);
            if($result){
                $this->success('编辑分类成功！');
            }else{
                $this->error('编辑分类失败');
            }
        }else{
            $categoryQuery = Db::name('push_category');
            $where = ['id' => $categoryId];
            $category = $categoryQuery->where($where)->find();
            if (empty($category)) {
                $this->error('未找到对应的分类数据');
            }
            $this->assign('category', $category);
            return $this->fetch();
        }

    }

    /**
     * 互推分类删除
     * @author xy
     * @since 2017/09/12 23：21
     */
    public function category_delete(){
        $categoryId = input('param.id', 0);
        if(empty($categoryId)){
            $this->error('分类id缺失');
        }
        $result = Db::name('push_category')->where(['id'=>$categoryId])->delete();
        if($result){
            $this->success('删除分类成功');
        } else{
            $this->error('删除分类失败');
        }
    }

    /**
     * 商家互推类型
     * @author xy
     * @since 2017/09/18 21:44
     * @return mixed
     */
    public function type_index(){
        $name = input('request.name', '');
        $where = [];
        if(!empty($name))
            $where = [
                'name' => ['like', '%'.$name.'%']
            ];
        $typeQuery = Db::name('push_type')->alias('pt');

        $list = $typeQuery->where($where)
            ->field('pt.*, p.title')
            ->join('__PUSH__ p', 'p.id = pt.push_id', 'LEFT')
            ->paginate(10);
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 商家互推类型添加
     * @author xy
     * @since 2017/09/18 21:45
     * @return mixed
     */
    public function type_add(){
        if(Request::instance()->isAjax()){
            $name = input('param.name', '');
            $pushId = input('param.push_id', 0);
            if(empty($name)){
                $this->error('请填写类型名称');
            }
            if(empty($pushId)){
                $this->error('请填写互推id');
            }
            $data = [
                'name' => $name,
                'push_id' => $pushId,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $result = Db::name('push_type')->insertGetId($data);
            if(empty($result)){
                $this->error('添加类型失败');
            }
            $this->success('添加成功', url('push/type_index'));
        }else{
            return $this->fetch();
        }
    }

    /**
     * 商家互推类型编辑
     * @author xy
     * @since 2017/09/18 21：47
     * @return mixed
     */
    public function type_edit(){
        $id = input('param.id', 0);
        if(empty($id)){
            $this->error('数据传入失败！');
        }
        if(Request::instance()->isAjax()){
            $typeName = input('param.name', '');
            if(empty($typeName)){
                $this->error('请填写分类名称！');
            }
            $data = [
                'name' => $typeName,
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $result = Db::name('push_type')->where(['id' => $id])->update($data);
            if($result){
                $this->success('编辑类型成功！');
            }else{
                $this->error('编辑类型失败');
            }
        }else{
            $typeQuery = Db::name('push_type');
            $where = ['id' => $id];
            $type = $typeQuery->where($where)->find();
            if (empty($type)) {
                $this->error('未找到对应的类型数据');
            }
            $this->assign('type', $type);
            return $this->fetch();
        }
    }

    /**
     * 删除商家互推类型
     * @author xy
     * @since 2017/09/18 21:50
     */
    public function type_delete(){
        $id = input('param.id', 0);
        if(empty($id)){
            $this->error('分类id缺失');
        }
        $result = Db::name('push_type')->where(['id'=>$id])->delete();
        if($result){
            $this->success('删除类型成功');
        } else{
            $this->error('删除类型失败');
        }
    }

    /**
     * 商家互推标签
     * @author xy
     * @since 2017/09/21 00:01
     * @return mixed
     */
    public function tag_index(){
        $name = input('request.name', '');
        $where = [];
        if(!empty($name))
            $where = [
                'pt.name' => ['like', '%'.$name.'%']
            ];
        $tagQuery = Db::name('push_tags')->alias('pt');

        $list = $tagQuery->where($where)
            ->field('pt.*, p.title')
            ->join('__PUSH__ p', 'p.id = pt.push_id', 'LEFT')
            ->paginate(10);
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 商家互推标签添加
     * @author xy
     * @since 2017/09/21 00:01
     * @return mixed
     */
    public function tag_add(){
        if(Request::instance()->isAjax()){
            $name = input('param.name', '');
            $pushId = input('param.push_id', 0);
            if(empty($name)){
                $this->error('请填写标签名称');
            }
            if(empty($pushId)){
                $this->error('请填写互推id');
            }
            $data = [
                'name' => $name,
                'push_id' => $pushId,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $result = Db::name('push_tags')->insertGetId($data);
            if(empty($result)){
                $this->error('添加标签失败');
            }
            $this->success('添加成功', url('push/tag_index'));
        }else{
            return $this->fetch();
        }
    }

    /**
     * 商家互推标签编辑
     * @author xy
     * @since 2017/09/21 00:02
     * @return mixed
     */
    public function tag_edit(){
        $id = input('param.id', 0);
        if(empty($id)){
            $this->error('数据传入失败！');
        }
        if(Request::instance()->isAjax()){
            $name = input('param.name', '');
            if(empty($name)){
                $this->error('请填写标签名称！');
            }
            $data = [
                'name' => $name,
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $result = Db::name('push_tags')->where(['id' => $id])->update($data);
            if($result){
                $this->success('编辑类型成功！');
            }else{
                $this->error('编辑类型失败');
            }
        }else{
            $tagQuery = Db::name('push_tags');
            $where = ['id' => $id];
            $tag = $tagQuery->where($where)->find();
            if (empty($tag)) {
                $this->error('未找到对应的标签数据');
            }
            $this->assign('tag', $tag);
            return $this->fetch();
        }
    }

    /**
     * 删除商家互推类型
     * @author xy
     * @since 2017/09/21 00:05
     */
    public function tag_delete(){
        $id = input('param.id', 0);
        if(empty($id)){
            $this->error('标签id缺失');
        }
        $result = Db::name('push_tags')->where(['id'=>$id])->delete();
        if($result){
            $this->success('删除标签成功');
        } else{
            $this->error('删除标签失败');
        }
    }
}