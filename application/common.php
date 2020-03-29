<?php
use think\Db;

if(!function_exists('getCatName')){
    function getCatName($cat_id)
    {
        return Db::table('gzvd_cat')->where('id',$cat_id)->value('name');
    }
}