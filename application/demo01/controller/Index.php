<?php
namespace app\demo01\controller;
use app\demo01\common\controller\Base;
use think\facade\Cookie;

class Index extends Base
{
    public function Index()
    {
        Cookie::set('name12','password',['prefix'=>'thinkphp_']);
        return $this->fetch();
    }

}