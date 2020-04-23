<?php
namespace app\jd\controller;
use app\jd\common\controller\Base;
use app\jd\common\model\Jduser;
use think\facade\Request;
use app\jd\common\model\Jddatetype as JddatetypeModel;
use app\jd\common\model\Jduser as JduserModel;

class Check extends Base
{
    public function user()
    {
        $datetype_id = Request::param('datetype_id');
        $users = Jduser::where('datetype_id',$datetype_id)->order('id','asc')->select();
        $this->assign('users',$users);
        return $this->view->fetch();
    }

    public function exp()
    {
        $exp_num = Request::param('exp_num');
        $index = Request::param('index');
        $res = getJd($exp_num);
//        halt($res);
        if($res == '1'){
            return ['status'=>1,"msg"=>"已签收","index"=>$index];
        }elseif($res == '4'){
            return ['status'=>4,"msg"=>"<button style='background-color: #00FF00;'>单号不对</button>","index"=>$index];
        }else{
            return ['status'=>2,"msg"=>"<button style='background-color: #00FF00;'>在途中</button>","index"=>$index,"route"=>$res[0],"time"=>$res[1]];
        }
    }

    public function status()
    {
        $data = Request::param();
        $data['id'] = $data['user_id'];
        unset($data['user_id']);
        $res = JduserModel::update($data);
        if($res){
            return ['status'=>1,"msg"=>"更新成功"];
        }
    }

    public function deluser()
    {
        $datetype_id = Request::param('datetype_id');
        $res = JduserModel::where('datetype_id',$datetype_id)->delete();
        return ['status'=>1,"msg"=>"删除成功"];
    }

    public function deldatetypeid()
    {
        $datetype_id = Request::param('datetype_id');
        $res = JddatetypeModel::where('id',$datetype_id)->delete();
        return ['status'=>1,"msg"=>"删除目录成功"];
    }



}
