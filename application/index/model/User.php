<?php
namespace app\index\Model;

use \think\Model;
use \think\Db;
use \think\Session;
class User extends Model
{
    // 验证用户登录
    // $post 提交的表单数据
    public function check_login($post)
    {
        if (!empty($post)) {
            if (!limitLogin($post['phone'])) {
                echo 15;exit;
            }
            if (!limitIpLogin()) {
                echo 16;exit;
            }
            if (empty($post['phone'])) {
                echo 2;exit;
            }
            if (empty($post['pass_word'])) {
                echo 3;exit;
            }
            if (!is_numeric($post['phone']) || strlen($post['phone']) != 11 || preg_match('/^0?(13|14|15|17|18)[0-9]{9}$/', $post['phone']) != 1) {
                echo 7;exit;
            }
            if (Db::name('user')->where("phone = :phone")->bind(['phone' => $post['phone']])->count() == 0) {
                echo 1;exit;
            }
            //对密码进行md5加密
            $post['md5_pass_word'] = md5($post['pass_word']);
            $data = Db::name('user')
                                ->field('id, phone, user_name, is_black, is_vip, is_real_name, default_head')
                                ->where("phone = :phone and pass_word = :pass_word")
                                ->bind(['phone' => $post['phone'], 'pass_word' => $post['md5_pass_word']])
                                ->find();
            if (empty($data)) {
                echo 10;exit;
            }
            if ($data['is_black'] == 1) {
                echo 500;exit;
            }
            // 修改用户的上次登录时间
            $last_time['login_time'] = time();
            $user_detail = Db::name('user_detail')
                                        ->where('user_id', '=', $data['id'])
                                        ->update(['login_time' => time()]);
            if ($user_detail) {
                Session::set('user_info', $data);
                echo 200;exit;
            }
            echo 10;exit;
        }
    }

    // 验证用户注册
    // $post 提交的表单数据
    public function check_register($post)
    {
        if (!empty($post)) {
            //验证是否同意协议
            if (!$post['protocol']) {
                echo 6;exit;
            }
            //验证确认密码是否为空
            if (!$post['check_pass_word']) {
                echo 4;exit;
            }
            //验证验证码是否为空
            if (!$post['verify']) {
                echo 5;exit;
            }
            //验证手机号码格式
            if (!is_numeric($post['phone']) || strlen($post['phone']) != 11 || preg_match('/^0?(13|14|15|17|18)[0-9]{9}$/', $post['phone']) != 1) {
                echo 7;exit;
            }
            //验证密码格式
            if (preg_match('/^[0-9a-zA-Z]{6,12}$/', $post['pass_word']) != 1 || preg_match('/^[0-9a-zA-Z]{6,12}$/', $post['check_pass_word']) != 1) {
                echo 8;exit;
            }
            //验证密码和确认密码是否一致
            if ($post['pass_word'] !== $post['check_pass_word']) {
                echo 9;exit;
            }
            //加密密码 删除无用数据
            $post['pass_word'] = md5($post['pass_word']);
            unset($post['check_pass_word'], $post['checked'], $post['protocol'], $post['verify']);
            $post['user_name'] = $post['phone'];
            //查询是否已经注册
            $is_reg = Db::table('jcwy_user')->where("phone = '$post[phone]'")->count();
            if ($is_reg != 0) {
                echo 14;exit;
            }
            // 注册基本信息
            $id = Db::name('user')->insertGetId($post);
            if (!$id) {
                echo 12;exit;
            }
            // 注册详细信息
            $detail_info['user_id'] = $id;
            $detail_info['login_time'] = $detail_info['reg_time'] = time();
            $detail_info['login_ip'] = getIp();
            $detail_info['id'] = Db::name('user_detail')->insert($detail_info);
            if (!$detail_info['id']) {
                echo 12;exit;
            }
            $post['detail'] = $detail_info;
            // 添加默认头像地址
            $post['default_head'] = '/ThinkPHP5/public/static/img/default.jpg';
            Session::set('user_info', $post);
            echo 200;exit;
        }
    }
}