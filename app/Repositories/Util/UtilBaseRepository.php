<?php

namespace App\Repositories\Util;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/14
 * Time: 11:32
 */
abstract class UtilBaseRepository extends BaseRepository
{
    //设置一些不被限制查询数据范围的角色
    //所有数据
    public static  $DATA_SCOPE_ALL = '1';
    //所在公司及以下数据
    public static $DATA_SCOPE_COMPANY_AND_CHILD = '2';
    //仅所在公司数据
    public static $DATA_SCOPE_COMPANY = '3';
    //仅本人可见
    public static $DATA_SCOPE_SELF = '8';

    /**
     * 数据范围过滤
     * @param user 当前用户对象，通过“entity.getCurrentUser()”获取
     * @param officeAlias 机构表别名，多个用“,”逗号隔开。
     * @param userAlias 用户表别名，多个用“,”逗号隔开，传递空，忽略此参数
     * @return 标准连接条件对象
     */
    public function dataScopeFilter($model,$officeAlias='', $userAlias='') {
        //phpinfo();
        //dd();

        // 进行权限过滤，多个角色权限范围之间为或者关系。
        //List<String> dataScope = Lists.newArrayList();

        $model->where(function($q1) use($officeAlias,$userAlias){
            $user = Auth::user();
            // 进行权限过滤，多个角色权限范围之间为或者关系。
            $dataScope = [];

            //查询出该用户的所有角色信息
            $roles = $user->roles()->get();
            // 超级管理员，跳过权限过滤
            if (!$user->isAdmin()){
                $isDataScopeAll = false;
                foreach ($roles as $role){
                    $oas = explode(",", $officeAlias);
                    foreach ($oas as $oa){
                        if (!in_array($oa, $dataScope) && $oa!='') {
                            if ($this::$DATA_SCOPE_ALL == $role->data_scope) {
                                $isDataScopeAll = true;
                            } else if ($this::$DATA_SCOPE_COMPANY_AND_CHILD == $role->data_scope) {
                                $q1->orWhere($oa.".id",'=',$user->office()->get()[0]->id);
                                $q1->orWhere($oa.".parent_ids",'like',$user->office()->get()[0]->parent_ids.$user->office()->get()[0]->id.',%');
                            } else if ($this::$DATA_SCOPE_COMPANY == $role->data_scope) {
                                $q1->orWhere($oa.".id",'=',$user->office()->get()[0]->id);
                            }
                            $dataScope[] = $role->data_scope;
                        }
                    }
                }
                // 如果没有全部数据权限，并设置了用户别名，则当前权限为本人；如果未设置别名，当前无权限为已植入权限
                if (!$isDataScopeAll){
                    if ($userAlias!=''){
                        $us = explode(",", $userAlias);
                        foreach ($us as $u){
                            $q1->orWhere($u.".id",'=',$user->id);
                        }
                    }
                }
            }
        });
        return "";
    }
}