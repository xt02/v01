<?php
namespace app\index\controller;
use app\index\common\controller\Base;
use think\facade\Request;
use app\index\common\model\Cat as CatModel;
use app\index\common\model\Chap as ChapModel;

class Index extends Base
{
    public function index()
    {
        //渲染课程目录
        $catList = CatModel::where('status',1)->order('sort','asc')->select();
        $this->view->assign('catList',$catList);
        //渲染章节标题
        $catId = Request::param('catid')? Request::param('catid') : 0;
        $chapList = ChapModel::where('cat_id',$catId)->where('status',1)->order('sort','asc')->select();
        $this->view->assign('chapList',$chapList);
        //渲染章节标题url
        $chapId = Request::param('id') ? Request::param('id') : 1;
        if($catId == 0 || $chapId != 1){
            $chapUrl = ChapModel::where('id',$chapId)->value('tburl');
        }else{
            $chapUrl = ChapModel::where('cat_id',$catId)->order('sort','asc')->value('tburl');
        }
        $this->view->assign('chapUrl',$chapUrl);
        return $this->view->fetch();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function demo()
    {
        return $this->view->fetch();
    }
}
