<?php

namespace app\admin\controller;
use app\admin\common\controller\Base;
use app\admin\common\model\Chap as ChapModel;
use think\facade\Request;

class Chap extends Base
{
    public function ChapEdit()
    {
        $catId = Request::param('id');
        $chapInfo = ChapModel::where('cat_id',$catId)->select();
        $this->assign('title','章节编辑');
        $this->view->assign('empty','<span style="color:red">没有分类</span>');
        $this->assign('chapInfo',$chapInfo);
        return $this->fetch('chapedit');
    }

    public function Save()
    {
        $data = Request::param();
        if(ChapModel::where('id',$data['id'])->data($data)->Update()){
            return ['status' => 1, 'message' => '恭喜，更新成功 (*￣︶￣)'];
        }
        return ['status' => 0, 'message' => '更新失败'];
    }

}