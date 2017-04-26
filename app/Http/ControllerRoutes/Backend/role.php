<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 13:29
 */
//Route::resource('role', 'Backend\RoleController');

Route::any('role', ['as' => 'backend.role.index', 'uses' => 'Backend\RoleController@index']);
Route::any('role/create', ['as' => 'backend.role.create', 'uses' => 'Backend\RoleController@create']);
Route::any('role/store', ['as' => 'backend.role.store', 'uses' => 'Backend\RoleController@store']);
Route::any('role/show', ['as' => 'backend.role.show', 'uses' => 'Backend\RoleController@show']);
Route::any('role/edit', ['as' => 'backend.role.edit', 'uses' => 'Backend\RoleController@edit']);
Route::any('role/delete', ['as' => 'backend.role.delete', 'uses' => 'Backend\RoleController@delete']);