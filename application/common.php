<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 获取用户的ip
function getIP() { 

    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR"); 
    } else if (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknow";
    }
    return $ip;
}

// 限制用户的登录次数 前台
function limitLogin($phone) {
    // if (isset($_SESSION['phone']['time']) && $_SESSION['phone']['time'] == time()) {
    //         $_SESSION['phone']['login_num'] = 1;
    //         unset($_SESSION['phone']['time']);
    // }
    // $arr['phone'] = $phone;
    // $arr['login_num'] = 0;
    // $_SESSION['phone'] = $arr;
    // if ($_SESSION['phone']['login_num'] == 6) {
    //     if (isset($_SESSION['phone']['time'])) {
    //         return false;
    //     }
    //     $_SESSION['phone']['time'] = time()+1800;
    //     return false;
    // }
    // $_SESSION['phone']['login_num'] = $_SESSION['phone']['login_num']+1;
    return true;
}

// 限制ip的登录次数 前台
function limitIpLogin() {
    // if (isset($_SESSION['ip']['time']) && $_SESSION['ip']['time'] == time()) {
    //     $_SESSION['ip']['num'] = 1;
    //     unset($_SESSION['ip']['time']);
    // }
    // if ($_SESSION['ip']['num'] == 13) {
    //     if (isset($_SESSION['ip']['time'])) {
    //         return false;
    //     }
    //     $_SESSION['ip']['time'] = time()+3600;
    //     return false;
    // }
    // $_SESSION['ip'] =  getIp();
    // $_SESSION['ip']['num'] = $_SESSION['ip']['num']+1;
    return true;
}

// 限制用户的登录次数 后台
function limitAdminLogin() {
    if ($_SESSION['admin_login_num']['time'] == time()) {
            $_SESSION['admin_login_num'] = 1;
            unset($_SESSION['admin_login_num']['time']);
    }
    if ($_SESSION['admin_login_num'] == 4) {
        if (isset($_SESSION['admin_login_num']['time'])) {
            return false;
        }
        $_SESSION['admin_login_num']['time'] = time()+1800;
        return false;
    } else {
            $_SESSION['admin_login_num'] += 1;
            return true;
    }
}