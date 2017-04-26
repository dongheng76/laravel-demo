<?php

namespace App\Presenters;

use App\Transformers\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\SysMenuRepositoryEloquent;
use Illuminate\Http\Request;

/**
 * Class UserPresenter
 *
 * @package namespace App\Presenters;
 */
class UserPresenter extends FractalPresenter
{
    protected $user;
    protected $sysMenu;

    public function __construct(UserRepositoryEloquent $user,SysMenuRepositoryEloquent $sysMenu)
    {
        $this->user = $user;
        $this->sysMenu = $sysMenu;
        parent::__construct();
    }

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserTransformer();
    }

    public function getUserName($userId)
    {
        $user = $this->user->find($userId, ['name']);
        if ($user) {
            return $user->name;
        }
    }

    public function getUserInfo($userId = 0) {
        $columns = ['id', 'name'];

        if ($userId > 0) {
            return $this->user->find($userId, $columns);
        }
        return $this->user->first($columns);

    }

    /**
     * 通过url查询当前菜单是否在该菜单id下
     */
    public function getParentIdsByUrl($url,Request $request){
        $sysMenu = $this->sysMenu->backendSearchSysMenu([['href','=',$url]]);
        $request->session()->put('currentParentIds',$sysMenu[0]['parent_ids']);
        $request->session()->put('currentSubMenuId',$sysMenu[0]['id']);
    }

    /**
     * 通过url查询当前菜单是否在该菜单id下
     */
    public function isChildByParentIds($menuId,Request $request){
        if(strpos($request->session()->get('currentParentIds'),$menuId.',')){
            return true;
        }else{
            return false;
        }
    }
}
