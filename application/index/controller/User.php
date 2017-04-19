<?php
namespace app\index\controller;

use \think\Controller;
use \think\Db;
class User extends Controller
{
    // 我的展厅
    public function userInfo()
    {
        return view('userInfo');
    }
    // 我的信息
    public function userData()
    {
        return view('userData');
    }
    // 我的认证
    public function userCert()
    {
        return view('userCert');
    }
    // 用户安全
    public function userSecurity()
    {
        return view('userSecurity');
    }
}