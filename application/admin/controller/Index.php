<?php
namespace app\admin\controller;
class Index extends Base
{
    public function index()
    {
    
        $this->assign('info',session(config('admin.session_cfg.info')));

        return view();
    }

    public function welcome()
    {
        return view();
    }

        /**

     * [logOut 退出]

     * @Author   roger

     * @DateTime 2018-11-15T11:30:53+0800

     * @return   [type]                   [description]

     */

     public function logOut(){

        // $log = $this->insertLog(6,0,'');

        session(null);

        return $this->success('退出成功','Login/index');

    }

}