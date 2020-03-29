<?php
namespace app\admin\controller;
use app\admin\common\controller\Base;

class Index extends Base
{
    public function Index()
    {
        return $this->fetch();
    }

}