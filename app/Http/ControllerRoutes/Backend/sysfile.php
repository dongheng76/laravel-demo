<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 13:31
 */
Route::get('fileframe', ['as' => 'backend.upload.fileframe', 'uses' => 'Backend\SysFileController@selectFrame']);
Route::resource('sysfile', 'Backend\SysFileController');
Route::get('upload', ['as' => 'backend.upload.index', 'uses' => 'Backend\UploadController@index']);
Route::get('getfiles', ['as' => 'backend.upload.getfiles', 'uses' => 'Backend\UploadController@getFiles']);
Route::get('getfolders', ['as' => 'backend.upload.getfiles', 'uses' => 'Backend\UploadController@getFolders']);
Route::delete('file-del', ['as' => 'backend.upload.file-del', 'uses' => 'Backend\UploadController@fileDelete']);
Route::get('dirdel', ['as' => 'backend.upload.dir-del', 'uses' => 'Backend\UploadController@dirDelete']);
Route::get('mkdir', ['as' => 'backend.upload.mkdir', 'uses' => 'Backend\UploadController@makeDir']);
Route::get('file-upload', ['as' => 'backend.upload.file-upload', 'uses' => 'Backend\UploadController@fileUpload']);
Route::get('imgzoom', ['as' => 'backend.upload.imgZoom', 'uses' => 'Backend\UploadController@imgZoom']);
Route::post('filestore', ['as' => 'backend.upload.file-store', 'uses' => 'Backend\UploadController@fileStore']);
Route::any('findareabypid', ['as' => 'backend.area.findareabypid', 'uses' => 'Backend\AreaController@findAreaByPid']);