<?php
namespace app\index\controller;

use \think\Controller;
use \think\Request;
use \think\Session;
class Login extends Controller
{
    public function login()
    {
        // 验证登录信息
        if (Request::instance()->isPost()) {
            $User = model('user');
            $User->check_login(input('post.'));
        } else {
            $this->redirect('Index/index');
        }
    }

    // 注销登录
    public function loginOff()
    {
        // 非法访问
        if (!input('post.')) $this->redirect('Index/index');
        // 删除信息
        if (Session::get('user_info')) Session::delete('user_info');
        echo 17;exit;
    }
}