<?php
namespace app\index\controller;

use \think\Controller;
use \think\Request;
class Register extends Controller
{
    public function register()
    {
        // 验证注册信息
        if (Request::instance()->isPost()) {
            $User = model('user');
            $User->check_register(input('post.'));
        } else {
            $this->redirect('Index/index');
        }
    }
}