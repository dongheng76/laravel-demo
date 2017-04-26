<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 13:24
 */
//Route::resource('menu', 'Backend\MenuController');

Route::any('menu', ['as' => 'backend.menu.index', 'uses' => 'Backend\MenuController@index']);
Route::any('menu/create', ['as' => 'backend.menu.create', 'uses' => 'Backend\MenuController@create']);
Route::any('menu/store', ['as' => 'backend.menu.store', 'uses' => 'Backend\MenuController@store']);
Route::any('menu/show', ['as' => 'backend.menu.show', 'uses' => 'Backend\MenuController@show']);
Route::any('menu/edit', ['as' => 'backend.menu.edit', 'uses' => 'Backend\MenuController@edit']);
Route::any('menu/delete', ['as' => 'backend.menu.delete', 'uses' => 'Backend\MenuController@delete']);