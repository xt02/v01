<?php
namespace app\jd\common\controller;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\Request;
use app\jd\common\model\Jddatetype as JddatetypeModel;
use app\jd\common\model\Jdlogin as JdloginModel;

class Base extends Controller
{
    //初始化方法
    protected function initialize()
    {
        $this->showDatetype();
        $this->isLogin();
    }

    protected function showDatetype()
    {
        $jddatetypes = JddatetypeModel::order('create_time','desc')->all();
        $this->assign('jddatetypes',$jddatetypes);
    }

    protected function isLogin()
    {
        if(!session::has('user_id')){
            //cookie数据存在并在数据库中,写入,返回true
            if(Cookie::has('user_id') and Cookie::has('user_name')){
                $user_id = Cookie::get('user_id');
                $user_name = Cookie::get('user_name');
                $res = JdloginModel::where(['id'=>$user_id,'uname'=>$user_name])->find();
                if($res){
                    Session::set('user_id',$res['id']);//将用户的数据写到session中
                    Session::set('user_name',$res->uname);
                }
            }
            if(Request::path() == 'jd/user/login'){
                return true;
            }
            return $this->redirect('user/login');
        }
    }

}