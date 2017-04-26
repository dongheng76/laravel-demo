<?php
namespace App\Util;

use Illuminate\Support\Facades\Redis;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/20
 * Time: 16:40
 */
class CacheUtils
{
    public static $SYS_CACHE = "sysCache";

    //取得系统缓存系统集
    public static function getSysCache(){
        return Redis::get(CacheUtils::$SYS_CACHE);
    }

    //取得一个缓存信息
    public static function get($cacheName){
        return unserialize(Redis::get($cacheName));
    }

    //取得cacche中的缓存中为key键的值
    public static function getCacheKey($cacheName, $key){
        $valueArray = unserialize(Redis::get($cacheName));
        return $valueArray[$key];
    }

    /**
     * 写入缓存
     * @param cacheName
     * @param key
     * @param value
     */
    public static function putCache($cacheName, $array) {
        Redis::set($cacheName,serialize($array));
    }

    /**
     * 写入缓存下的键值
     * @param cacheName
     * @param key
     * @param value
     */
    public static function put($cacheName, $key, $value) {
        $redisObj = unserialize(CacheUtils::getCache($cacheName));
        $redisObj[$key] = $value;
        Redis::set($cacheName,$redisObj,config('database.redis.expire'));
    }

    /**
     * 获得一个Cache，没有则显示日志。
     * @param cacheName
     * @return
     */
    private static function getCache($cacheName){
        $cache = unserialize(Redis::get($cacheName));
        if ($cache == null){
            $cache = array();
            Redis::set($cacheName,$cache,config('database.redis.expire'));
        }
        return $cache;
    }

    /**
     * 从缓存中移除所有
     * @param cacheName
     */
    public static function removeAll($cacheName) {
        Redis::set($cacheName,null);
    }

    /**
     * 从缓存中移除一个key的值
     * @param cacheName
     * @param key
     */
    public static function remove($cacheName, $key) {
        $cache = unserialize(Redis::get($cacheName));
        $cache[$key] = null;
        Redis::set($cacheName,$cache,config('database.redis.expire'));
    }
}