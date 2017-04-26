<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 13:33
 */
//resource访问规则
/**
 * Verb    Path                        Action  Route Name
GET     /users                      index   users.index
GET     /users/create               create  users.create
POST    /users                      store   users.store
GET     /users/{user}               show    users.show
GET     /users/{user}/edit          edit    users.edit
PUT     /users/{user}               update  users.update
DELETE  /users/{user}               destroy users.destroy
 */
//Route::resource('area', 'Backend\AreaController');

Route::any('area', ['as' => 'backend.area.index', 'uses' => 'Backend\AreaController@index']);
Route::any('area/create', ['as' => 'backend.area.create', 'uses' => 'Backend\AreaController@create']);
Route::any('area/store', ['as' => 'backend.area.store', 'uses' => 'Backend\AreaController@store']);
Route::any('area/show', ['as' => 'backend.area.show', 'uses' => 'Backend\AreaController@show']);
Route::any('area/edit', ['as' => 'backend.area.edit', 'uses' => 'Backend\AreaController@edit']);
Route::any('area/delete', ['as' => 'backend.area.delete', 'uses' => 'Backend\AreaController@delete']);