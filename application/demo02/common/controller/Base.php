<?php
namespace app\demo02\common\controller;
use think\Controller;
use think\facade\Cookie;

class Base extends Controller
{
    //初始化方法
    protected function initialize()
    {

    }

    public function isLogin()
    {
        if(Cookie::has('name12','thinkphp_')){
            return $this->redirect('index/index02');
        }
    }

}