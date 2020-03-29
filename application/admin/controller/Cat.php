<?php
namespace app\admin\controller;
use app\admin\common\controller\Base;
use app\admin\common\model\Cat as CatModel;
use think\facade\Request;

class Cat extends Base
{
    public function CatList()
    {
        $catList = CatModel::all();
        $this->assign('title','课程目录管理');
        $this->assign('empty','<span style="color:red">没有分类</span>');
        $this->assign('catList',$catList);
        return $this->fetch('catlist');
    }

    public function CatEdit()
    {
        $catId = Request::param('id');
        $catInfo = CatModel::where('id',$catId)->find();
        $this->assign('title','分类编辑');
        $this->view->assign('empty','<span style="color:red">没有分类</span>');
        $this->assign('catInfo',$catInfo);
        return $this->fetch('catedit');
    }

    public function doEdit()
    {
        $data = Request::param();
        if(CatModel::where('id',$data['id'])->data($data)->Update()){
            return $this->success('更新成功','catList');
        }
        $this->error('更新失败');
    }

}