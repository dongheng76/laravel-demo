<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 13:34
 */
//Route::resource('dict', 'Backend\DictController');

Route::any('dict', ['as' => 'backend.dict.index', 'uses' => 'Backend\DictController@index']);
Route::any('dict/create', ['as' => 'backend.dict.create', 'uses' => 'Backend\DictController@create']);
Route::any('dict/store', ['as' => 'backend.dict.store', 'uses' => 'Backend\DictController@store']);
Route::any('dict/show', ['as' => 'backend.dict.show', 'uses' => 'Backend\DictController@show']);
Route::any('dict/edit', ['as' => 'backend.dict.edit', 'uses' => 'Backend\DictController@edit']);
Route::any('dict/delete', ['as' => 'backend.dict.delete', 'uses' => 'Backend\DictController@delete']);