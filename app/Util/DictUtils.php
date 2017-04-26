<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/21
 * Time: 9:53
 */

namespace App\Util;

use App\Util\CacheUtils;
use App\Repositories\DictRepositoryEloquent;
use DB;

class DictUtils
{
    public static $CACHE_DICT_MAP = "dictMap";

    /**
     * 根据单个值的key查询对应的label值
     */
    public static function getDictLabel($value, $type, $defaultValue){
        foreach (DictUtils::getDictList($type) as $dict){
            if ($type==$dict->type && $value==$dict->value){
                return $dict->label;
            }
        }
        return $defaultValue;
    }

    public static function getDictList($type){
        $dictArray = null;
        if ($dictArray==null){
            //查询所有有效的字典信息
            $dicts = DB::select("select * from sys_dict where del_flag='0'");
            $dictArray = array();
            foreach ($dicts as $dict){
                if(isset($dictArray[$dict->type])){
                    $dictArray[$dict->type][] = $dict;
                }else{
                    $dictArray[$dict->type] = array();
                    $dictArray[$dict->type][] = $dict;
                }
            }
            CacheUtils::putCache(DictUtils::$CACHE_DICT_MAP, $dictArray);
        }
        $dictList = $dictArray[$type];
        if ($dictList == null){
            $dictList = array();
        }
        return $dictList;
    }
}