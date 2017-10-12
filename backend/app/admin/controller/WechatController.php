<?php
/**
 * 微信公众号管理
 * User: admin
 * Date: 2017/9/11
 * Time: 23:26
 */

namespace app\admin\controller;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

class WechatController extends AdminBaseController
{
    /**
     * 商家互推列表
     * @author xy
     * @since 2017/09/11 23:28
     */
    public function index(){
        $request = input('request.');
        $query = Db::name('wechat');
        $where = [];
        if(!empty($request['name'])){
            $where['name'] = ['like', '%'.$request['name'].'%'];
        }
        if(!empty($request['wechat_account'])){
            $where['wechat_account'] = ['like', '%'.$request['wechat_account'].'%'];
        }
        if(!empty($request['wechat_category'])){
            $where['wechat_category'] = $request['wechat_category'];
        }
        if(!empty($request['resource_type'])){
            $where['resource_type'] = $request['resource_type'];
        }
        //'
        $list = $query->alias('w')
            ->field(
                'w.*, wc.name as category_name, GROUP_CONCAT(wt.id) as tag_ids, GROUP_CONCAT(wt.name) as tags'
            )
            ->join('__WECHAT_CATEGORY__ wc', 'w.wechat_category = wc.id', 'LEFT')
            ->join('__WECHAT_TAGS__ wt', 'wt.wechat_id = w.id', 'LEFT')
            ->where($where)
            ->group('w.id')
            ->paginate(15);
        // 获取分页显示
        $page = $list->render();
        //微信分类的option
        $option = $this->generateWechatTypeOption();

        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('option', $option);

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

            $insertTagData = array();
            if(!empty($editData['new_tag_name'])){
                $tegArr = explode(',',$editData['new_tag_name']) ;
                foreach ($tegArr as $gKey => $tag){
                    $insertTagData[$gKey]['name'] = $tag;
                    $insertTagData[$gKey]['create_time'] = date('Y-m-d H:i:s', time());
                    $insertTagData[$gKey]['wechat_id'] = $id;
                }
            }
            if(!empty($editData['del_tag_id'])){
                $delTagIdArr = explode(',',$editData['del_tag_id']) ;
            }
            unset($editData['new_tag_name'],$editData['del_tag_id']);
            Db::startTrans();
            $result = Db::name('wechat')->where(['id' => $id])->update($editData);
            //echo $sql =  Db::name('wechat')->getLastSql();
            if($result){
                if(!empty($insertTagData)){
                    $result = Db::name('wechat_tags')->insertAll($insertTagData);
                    if(!$result){
                        Db::rollback();
                    }
                }

                if(!empty($delTagIdArr)){
                    foreach ($delTagIdArr as $tagId){
                        $result = Db::name('wechat_tags')->where(['id' => $tagId])->delete();
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
                'w.id' => $id,
            ];
            $processWechat = Db::name('wechat')->alias('w')->where($where)->find();
            if(empty($processWechat['id'])){
                $this->error('未找到对应的数据', url('admin/wechat/index'));
            }
            if(empty($processWechat['is_process'])){
                //处理type字段的数据
                $wechatProcessData = array(
                    'is_process' => 1,
                );

                if(!empty($processWechat['tag'])){

                    $pTagArr = array_unique(explode(',', $processWechat['tag']));
                    $pInsertTagData = array();
                    foreach ($pTagArr as $tKey=>$tag){
                        if(!empty($tag)){
                            $pInsertTagData[$tKey]['name'] = $tag;
                            $pInsertTagData[$tKey]['wechat_id'] = $id;
                            $pInsertTagData[$tKey]['create_time'] = date('Y-m-d', time());
                        }
                    }
                    if(!empty($pInsertTagData)){
                        $result = Db::name('wechat_tags')->insertAll($pInsertTagData);
                        if(!$result){
                            $this->error('数据处理失败');
                        }
                        $wechatProcessData['tag'] = '';
                    }
                }
                //处理address字段数据
                if(!empty($processWechat['address'])){
                    $addressArr = explode(' ', trim($processWechat['address']));
                    if(!empty($addressArr)){
                        foreach ($addressArr as $addr){
                            if(!empty($addr)){
                                $region = process_pick_region_data($addr);
                                if(!empty($region)){
                                    foreach ($region as $rKey => $rId){
                                        $wechatProcessData[$rKey] = $rId;
                                    }
                                }
                            }
                        }
                    }
                }
                if(!empty($wechatProcessData)){
                    $processResult = Db::name('wechat')->where(['id' => $id])->update($wechatProcessData);
                    if(!$processResult){
                        $this->error('数据处理失败');
                    }
                }
            }

            $wechat = Db::name('wechat')->alias('w')
                ->field(
                    'w.*, GROUP_CONCAT(wt.id) as tag_ids, GROUP_CONCAT(wt.name) as tags'
                )
                ->join('__WECHAT_TAGS__ wt', 'wt.wechat_id = w.id', 'LEFT')
                ->where($where)
                ->find();

            //获取互推分类数据
            $option = $this->generateWechatTypeOption($wechat['wechat_category']);

            $this->assign('option', $option);
            $this->assign('wechat', $wechat);
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
            $tagStr = trim($insertData['new_tag_name']);
            unset($insertData['new_tag_name']);
            $insertData['tag'] = $tagStr;
            $insertData['add_time'] = date('Y-m-d H:i:s');
            // 启动事务
            Db::startTrans();
            $wechatId = Db::name('wechat')->insertGetId($insertData);
            if($wechatId){
                if (!empty($tagStr)) {
                    $tagArr = explode(',', $tagStr);
                    $insertTagDate = [];
                    foreach ($tagArr as $key => $value) {
                        if(!empty($value)){
                            $insertTagDate[$key]['wechat_id'] = $wechatId;
                            $insertTagDate[$key]['name'] = $value;
                            $insertTagDate[$key]['create_time'] = date('Y-m-d H:i:s', time());
                        }
                    }
                    if(!empty($insertTagDate)){
                        $result = Db::name('wechat_tags')->insertAll($insertTagDate);
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

            }else{
                // 回滚事务
                Db::rollback();
                $this->error('添加失败');
            }
        }else{
            //获取微信类型option
            $option = $this->generateWechatTypeOption();
            $this->assign('option', $option);
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
        $result = Db::name('wechat')->where(['id'=>$id])->delete();
        if($result){
            $this->success('删除成功');
        } else{
            $this->error('删除失败');
        }
    }

    /**
     * 微信类型管理
     * @author xy
     * @since 2017/10/09 21:41
     */
    public function category_index(){
        $name = input('request.name', '');
        $parentId = input('param.parent_id',0);
        $where = ['parent_id' => $parentId];
        if(!empty($name)){
            $where['name'] =  ['like', '%'.$name.'%'];
        }

        $categoryQuery = Db::name('wechat_category');

        $list = $categoryQuery->where($where)->paginate(10);
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 微信分类添加
     * @author xy
     * @since 2017/10/09 23:20
     * @return mixed
     */
    public function category_add(){
        if(Request::instance()->isAjax()){
            $name = input('param.name', '');
            $parentId = input('param.parent_id', 0);
            $level = input('param.level');
            if(empty($name)){
                $this->error('请填写分类名称');
            }
            if(empty($level)){
                $this->error('层级不能为空');
            }
            $data = [
                'name' => $name,
                'add_time' => date('Y-m-d H:i:s'),
                'level' => $level+1,
                'parent_id' => $parentId,
            ];
            $result = Db::name('wechat_category')->insertGetId($data);
            if(empty($result)){
                $this->error('添加分类失败');
            }
            $this->success('添加成功', url('wechat/category_index'));
        }else{
            $option = $this->generateWechatTypeOption();
            //echo ($option);
            $this->assign('option', $option);
            return $this->fetch();
        }
    }

    /**
     * 微信类型编辑
     * @author xy
     * @since 2017/10/09 23:59
     */
    public function category_edit(){
        $categoryId = input('param.id', 0);
        if(empty($categoryId)){
            $this->error('数据传入失败！');
        }
        if(Request::instance()->isAjax()){
            $name = input('param.name', '');
            $level = input('param.level');
            if(empty($name)){
                $this->error('请填写分类名称！');
            }
            if(empty($level)){
                $this->error('层级分类不能为空');
            }
            $data = [
                'name' => $name,
                'level' => $level + 1,
            ];
            $result = Db::name('wechat_category')->where(['id' => $categoryId])->update($data);
            if($result){
                $this->success('编辑分类成功！');
            }else{
                $this->error('编辑分类失败');
            }
        }else{
            $categoryQuery = Db::name('wechat_category');
            $where = ['id' => $categoryId];
            $category = $categoryQuery->where($where)->find();
            if (empty($category)) {
                $this->error('未找到对应的分类数据');
            }
            $category['level'] = $category['level'] - 1;
            $option = $this->generateWechatTypeOption($category['parent_id']);
            $this->assign('option', $option);
            $this->assign('category', $category);
            return $this->fetch();
        }

    }

    /**
     * 互推分类删除
     * @author xy
     * @since 2017/10/09 23:21
     */
    public function category_delete(){
        $categoryId = input('param.id', 0);
        if(empty($categoryId)){
            $this->error('分类id缺失');
        }
        $result = Db::name('wechat_category')->where(['id'=>$categoryId])->delete();
        if($result){
            $this->success('删除分类成功');
        } else{
            $this->error('删除分类失败');
        }
    }

    /**
     * 微信标签
     * @author xy
     * @since 2017/10/12 22:54
     * @return mixed
     */
    public function tag_index(){
        $name = input('request.name', '');
        $where = [];
        if(!empty($name))
            $where = [
                'pt.name' => ['like', '%'.$name.'%']
            ];
        $tagQuery = Db::name('wechat_tags')->alias('wt');

        $list = $tagQuery->where($where)
            ->field('wt.*, w.wechat_name')
            ->join('__WECHAT__ w', 'w.id = wt.wechat_id', 'LEFT')
            ->paginate(10);
        // 获取分页显示
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }

    /**
     * 微信标签添加
     * @author xy
     * @since 2017/10/12 22:54
     * @return mixed
     */
    public function tag_add(){
        if(Request::instance()->isAjax()){
            $name = input('param.name', '');
            $wechatId = input('param.wechat_id', 0);
            if(empty($name)){
                $this->error('请填写标签名称');
            }
            if(empty($pushId)){
                $this->error('请填写互推id');
            }
            $data = [
                'name' => $name,
                'wechat_id' => $wechatId,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $result = Db::name('wechat_tags')->insertGetId($data);
            if(empty($result)){
                $this->error('添加标签失败');
            }
            $this->success('添加成功', url('wechat/wechat_index'));
        }else{
            return $this->fetch();
        }
    }

    /**
     * 微信标签编辑
     * @author xy
     * @since 2017/10/12 22:54
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
            $result = Db::name('wechat_tags')->where(['id' => $id])->update($data);
            if($result){
                $this->success('编辑类型成功！');
            }else{
                $this->error('编辑类型失败');
            }
        }else{
            $tagQuery = Db::name('wechat_tags');
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
     * 删除微信标签
     * @author xy
     * @since 2017/10/12 22:54
     * @return mixed
     */
    public function tag_delete(){
        $id = input('param.id', 0);
        if(empty($id)){
            $this->error('标签id缺失');
        }
        $result = Db::name('wechat_tags')->where(['id'=>$id])->delete();
        if($result){
            $this->success('删除标签成功');
        } else{
            $this->error('删除标签失败');
        }
    }

    /**
     * 生成微信类型的select
     * @author xy
     * @since 2017/10/11 23:14
     * @param int $defaultVal 默认选中值
     * @return string
     */
    protected function generateWechatTypeOption($defaultVal = 0){
        $categoryArr = Db::name('wechat_category')->select()->toArray();
        $categoryArr = get_tree_recursive($categoryArr, 0, 1, '3','level','id', 'parent_id', 'children');
        if(!empty($categoryArr)){
            return $option = generate_type_option($categoryArr, 'id', 'name', 'children', 'level', $defaultVal, '');
        }
        return '';
    }
}