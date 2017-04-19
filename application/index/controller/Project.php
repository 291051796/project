<?php
namespace app\index\controller;

use \think\Controller;
class Project extends Controller
{
    // 项目列表
    public function projectList()
    {
        return view("Project/projectList");
    }

    // 发布项目
    public function projectRelease()
    {
        $Project = model('project');

        // 验证是否已实名
        if (!$Project->checkRealName()) $this->success('您还未实名认证，正在跳转到实名认证界面', 'User/userCert', 2);

        echo "还未添加此功能！ :)";
    }
}