<?php
namespace app\jd\controller;
use app\jd\common\controller\Base;
use think\facade\Request;
use think\db;
use app\jd\common\model\Jddatetype as JddatetypeModel;
use app\jd\common\model\Jduser as JduserModel;
use app\jd\common\model\Jdlog as JdlogModel;

class Index extends Base
{
    public function index()
    {
        $this->isLogin();
        return $this->view->fetch();
    }

    public function insert()
    {
        $type_id = date("Y/m/d");
        $this->assign('type_id',$type_id);
        return $this->view->fetch();
    }

    public function save()
    {
        $data = Request::param();
        $type_name = $data['type_name'];
        //判断目录是否存在,如果不存在就创建
        $result = JddatetypeModel::get(function ($query) use ($type_name){
            $query->where('type_name', $type_name)->select();
        });
        if(is_null($result)){
            $datetype['type_name'] = $type_name;
            $result = JddatetypeModel::create($datetype);
        }
        $user['datetype_id'] = $result['id'];
        preg_match_all('/[A-Z]+.+/', $data['desc'],$arr);
        for($index=0;$index<sizeof($arr[0]);$index++){
            $res = explode('	',$arr[0][$index]);
            $user['exp_num'] = $res[0];
            $user['uname'] = $res[1];
            $user['utel'] = $res[2];
            $user['uadd'] = $res[3];
            $user['epecs'] = $res[4];
            JduserModel::create($user);
        }
        return $this->redirect('check/user',['datetype_id'=>$result['id']]);
    }

    public function log()
    {
        if(Request::post()){
            $data = Request::param();
            //查询在curTypeName和prevTypeName之间的所有用户
            $countepecs = Db::name('jd_user')->alias("a")->join('jd_datetype b','a.datetype_id = b.id')->field('b.type_name as type_name,count(a.id) as countId,sum(a.epecs)as epecs')->where([['b.type_name','>',$data['curTypeName']],['b.type_name','<=',$data['prevTypeName']]])->group('b.id')->order('b.type_name','asc')->select();
            return ['status'=>1,'countepecs'=>$countepecs];
        }

        $logs = Db::name('jd_log')->alias("a")->join('jd_datetype b','a.datetype_id = b.id')->field('a.id,a.epecs,a.prev,b.type_name')->order('b.type_name','desc')->select();

        $this->assign('logs',$logs);

        return $this->view->fetch();
    }

    public function addlog()
    {
        if(Request::post()){
            $data = Request::param();
            $res = JddatetypeModel::where('type_name',$data['type_name'])->find();
            if(is_null($res)){
                $datetype['type_name'] = $data['type_name'];
                $res = JddatetypeModel::create($datetype);
            }
            $result = JdlogModel::where('datetype_id',$res['id'])->find();
            $data['datetype_id']=$res['id'];
            unset($data['type_name']);
            if($result){
                JdlogModel::where('id',$result['id'])->update($data);
                return ['status'=>1,'msg'=>"更新数据成功"];
            }else{
                JdlogModel::create($data);
                return ['status'=>1,'msg'=>"添加数据成功"];
            }
        }
    }

}
