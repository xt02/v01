<?php
namespace app\index\common\model;
use think\Model;

class Chap extends Model
{
    protected $pk = 'id';//默认主键
    protected $table = 'gzvd_cat_chap';//默认数据表
    protected $autoWriteTimestamp = true;//自动时间戳
    protected $createtime = 'create_time';
    protected $updatetime = 'update_time';

}