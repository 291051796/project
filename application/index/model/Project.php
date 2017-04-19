<?php
namespace app\index\model;

use \think\Model;
use \think\Session;
use \think\Db;
class Project extends Model
{
    public function checkRealName()
    {
        $is_real_name = Db::name('user')
                            ->field('is_real_name')
                            ->where("id = :id")
                            ->bind(['id'=>Session::get('user_info.id')])
                            ->find();
        return $is_real_name ? true : false;
    }
}