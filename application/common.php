<?php
use think\Db;
use app\jd\common\model\Jduser as JduerModel;
use app\jd\common\model\Jddatetype as JddatetypeModel;

if(!function_exists('getCatName')){
    function getCatName($cat_id)
    {
        return Db::table('gzvd_cat')->where('id',$cat_id)->value('name');
    }
}

if(!function_exists('getUrl')){
    function getUrl($sinaUrl)
    {
        $url = 'http://tool.mkblog.cn/weibovideo/s.php?u=' . $sinaUrl;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);
        return $response['url'];
    }
}

if(!function_exists('getJd')){
    function getJd($num)
    {
        $url = 'http://m.46644.com/express/result.php?typetxt=gb2312&type=jd&number='.$num;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = mb_convert_encoding($output, 'utf-8','GB2312');
        preg_match_all('/<div class="icontent.+/', $output,$arr02);
//        print_r($arr02[0][0]);
        if(strpos($arr02[0][0],"京东物流")){
            if(updateStatus($num,1)==1){
                return 1;
            };
        }elseif(strpos($arr02[0][0],"没有信息") or strpos($arr02[0][0],"错误") ){
            if(updateStatus($num,4)){
                return 4;
            };
        }else{
            preg_match_all('/<div class="itime.+/', $output,$arr);
            $arr02[1] = $arr[0];
            return $arr02;
        };
    };
}

if(!function_exists('updateStatus')){
    function updateStatus($num,$status)
    {
        $data['status']=$status;
        $res = JduerModel::where('exp_num',$num)->data($data)->update();
        return $res;
    }
}

if(!function_exists('getDatetypeName')){
    function getDatetypeName($datetype_id)
    {
        $res = JddatetypeModel::where('id',$datetype_id)->value('type_name');
        return $res;
    }
}