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
namespace app\user\controller;

use cmf\controller\HomeBaseController;
use think\Validate;
use app\user\model\UserModel;

class RegisterController extends HomeBaseController
{

    /**
     * 前台用户注册
     */
    public function index()
    {
        $redirect = $this->request->post("redirect");
        if (empty($redirect)) {
            $redirect = $this->request->server('HTTP_REFERER');
        } else {
            $redirect = base64_decode($redirect);
        }
        session('login_http_referer', $redirect);

        if (cmf_is_user_login()) {
            return redirect($this->request->root() . '/');
        } else {
            return $this->fetch(":register");
        }
    }

    /**
     * 前台用户注册提交
     */
    public function doRegister()
    {
        if ($this->request->isPost()) {
            $rules = [
                'captcha'  => 'require',
                'code'     => 'require',
                'password' => 'require|min:6|max:32',

            ];

            $isOpenRegistration=cmf_is_open_registration();

            if ($isOpenRegistration) {
                unset($rules['code']);
            }

            $validate = new Validate($rules);
            $validate->message([
                'code.require'     => '验证码不能为空',
                'password.require' => '密码不能为空',
                'password.max'     => '密码不能超过32个字符',
                'password.min'     => '密码不能小于6个字符',
                'captcha.require'  => '验证码不能为空',
            ]);

            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            if (!cmf_captcha_check($data['captcha'])) {
                $this->error('验证码错误');
            }
            if($data['password'] != $data['repassword']){
                $this->error('两次密码不一致');
            }

            if(!$isOpenRegistration){
                $errMsg = cmf_check_verification_code($data['username'], $data['code']);
                if (!empty($errMsg)) {
                    $this->error($errMsg);
                }
            }

            $register          = new UserModel();
            $user['user_pass'] = $data['password'];
            if (Validate::is($data['username'], 'email')) {
                $user['user_email'] = $data['username'];
                $log                = $register->registerEmail($user);
            } else if (preg_match('/(^(13\d|15[^4\D]|17[13678]|18\d)\d{8}|170[^346\D]\d{7})$/', $data['username'])) {
                $user['mobile'] = $data['username'];
                $log            = $register->registerMobile($user);
            } else {
                $log = 2;
            }
            $sessionLoginHttpReferer = session('login_http_referer');
            $redirect                = empty($sessionLoginHttpReferer) ? cmf_get_root() . '/' : $sessionLoginHttpReferer;
            switch ($log) {
                case 0:
                    $this->success('注册成功，请及时验证您的邮箱', $redirect);
                    break;
                case 1:
                    $this->error("您的账户已注册过");
                    break;
                case 2:
                    $this->error("您输入的账号格式错误");
                    break;
                default :
                    $this->error('未受理的请求');
            }

        } else {
            $this->error("请求错误");
        }

    }

    /**
     * 激活邮箱账号
     * @author xy
     * @since 2017/10/26 00:12
     */
    public function active(){
        $token = $this->request->get('token', '');
        if(empty($token)){
            $this->error('参数错误，无法激活');
        }
        $user = new UserModel();
        $userInfo = $user->getUserByToken($token);
        if(!$userInfo){
            $this->error('参数错误，无法激活');
        }
        if($userInfo['is_active_account'] == 1){
            cmf_update_current_user($userInfo);
            $this->success('当前账号邮箱已激活', url('portal/Index/index'));
        }
        if($userInfo['token'] == $token && time()<=$userInfo['token_expire']){
            $userInfo['is_active_account'] = 1;
            cmf_update_current_user($userInfo);
            $this->success('当前账号邮箱激活成功', url('portal/Index/index'));
        }else{
            session(UserModel::SESSION_NEED_ACTIVE_ACCOUNT_UID, $userInfo['id']);
            $this->error('链接已失效');
        }

    }

    /**
     * 重新发送激活邮件
     * @author xy
     * @since 2017/10/30 23:38
     */
    public function resent_active_email(){
        $userId = session(UserModel::SESSION_NEED_ACTIVE_ACCOUNT_UID);
        if($userId){
            $user = UserModel::get($userId)->toArray();
            if(!$user){
                $this->error('抱歉，用户信息不存在，无法激活');
            }
            if($user['is_active_account']){
                unset($user['user_pass']);
                cmf_update_current_user($user);
                $this->success('用户已经激活，无需再发送邮件', url('Portal/Index/index'));
            }
            $result = resent_active_email($user);
            switch ($result){
                case 0:
                    $this->error('无法发送激活邮件或发送激活邮件失败');
                    break;
                case 1:
                    $this->success('用户已经激活，无需再发送邮件', url('Portal/Index/index'));
                    break;
                case 2:
                    $this->error('无法发送激活邮件或发送激活邮件失败');
                    break;
                case 3:
                    $this->success('激活邮件已发送至邮箱，请尽快激活账号');
                    break;
            }
        }
        $this->error('抱歉，用户信息不存在，无法激活');
    }
}