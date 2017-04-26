<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 13:33
 */
//Route::resource('office', 'Backend\OfficeController');

Route::any('office', ['as' => 'backend.office.index', 'uses' => 'Backend\OfficeController@index']);
Route::any('office/create', ['as' => 'backend.office.create', 'uses' => 'Backend\OfficeController@create']);
Route::any('office/store', ['as' => 'backend.office.store', 'uses' => 'Backend\OfficeController@store']);
Route::any('office/show', ['as' => 'backend.office.show', 'uses' => 'Backend\OfficeController@show']);
Route::any('office/edit', ['as' => 'backend.office.edit', 'uses' => 'Backend\OfficeController@edit']);
Route::any('office/delete', ['as' => 'backend.office.delete', 'uses' => 'Backend\OfficeController@delete']);