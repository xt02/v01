<?php
namespace app\demo02\controller;
use app\demo02\common\controller\Base;
use think\facade\Cookie;

class Index extends Base
{
    public function Index()
    {
        $this->isLogin();
        $this->assign('ech','11');
        return $this->fetch();
    }

    public  function Index02()
    {
        return $this->fetch();
    }

    public function logout()
    {
        Cookie::delete('name12','thinkphp_');
        return $this->redirect('index/index');
    }

}