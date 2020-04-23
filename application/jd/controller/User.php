<?php

namespace app\jd\controller;
use app\jd\common\controller\Base;
use think\facade\Request;
use think\facade\Session;
use think\facade\Cookie;
use app\jd\common\model\Jdlogin as JdloginModel;


class User extends Base
{
    public function login()
    {
        if(Request::post()){
            $data = Request::param();
            $res = JdloginModel::where(['uname'=>$data['uname'],'upwd'=>sha1($data['upwd'])])->find();
//            halt($res);
            //登录成功,写入session
            if($res){
                Session::set('user_id',$res['id']);//将用户的数据写到session中
                Session::set('user_name',$res->uname);
                Cookie::forever('user_id',$res['id']);
                Cookie::forever('user_name',$res->uname);
                $this->success('登录成功','index/index');
            }else{
                $this->error('用户名或密码错误','user/login');
            }

        }else{
            return $this->view->fetch();
        }
    }

    public function logOut()
    {
        Session::clear();
        Cookie::clear('user_id');
        Cookie::clear('user_name');
        return redirect('user/login');
    }

}