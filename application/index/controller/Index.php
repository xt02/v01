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
        return $this->redirect('jd/index/index');
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

    public function kuaidi()
    {
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
        $res = getUrl('https://weibo.com/tv/v/ICyVQ8UDE?fid=1034:4491906252472323');
        $this->view->assign('sinaUrl',$res);
        return $this->view->fetch();
    }

    public function jd(){
        $url = 'http://m.46644.com/express/result.php?typetxt=gb2312&type=jd&number=JDX001509602496';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = mb_convert_encoding($output, 'utf-8','GB2312');
        preg_match_all('/<div class="itime.+/', $output,$arr);
        print_r($arr[0]);
        preg_match_all('/<div class="icontent.+/', $output,$arr02);
        print_r($arr02[0]);
        return $output;
    }

}
