<?php
namespace Home\Model;

use Think\Model;
class UploadModel extends Model
{
    // 设置虚拟模型
    protected $autoCheckFields = false;

    public function upload_portrait($post)
    {

        $post['user_id'] = $_SESSION['user_info']['id'];
        $post['update_time'] = time();
        $post['portrait_name'] = time().substr(str_shuffle("123456789abcdefghijklmnopqrstuvwxyzABCDEFGHISJKLMOPQRSTUVWXYZ"), 0, 3);

        // 操作数据库
        $portrait = M('user_portrait');
        if (!$portrait->where("user_id = '$_SESSION[user_info][id]'")->add($post)) {
            // 修改失败
        }
        //修改成功
    }

}