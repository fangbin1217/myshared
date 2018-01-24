<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $loginPre = 'FB';

    protected $result = [];

    protected $modelCommon = ['header'=>[], 'sidebar'=>[], 'footer'=>[], 'myview'=>'', 'data'=>[]];

    public function __contract() {
        $this->result = $this->modelCommon;
        $this->result['login'] = [];
        if (isset($_SESSION['UNAME'])) {
            $this->result['login']['uname'] = $_SESSION['UNAME'];
            $this->result['login']['uid'] = $_SESSION['UID'];
            $this->result['login']['isAdmin'] = false;
            if (in_array($_SESSION['UID'], [1,2])) {
                $this->result['login']['isAdmin'] = true;
            }
            $tip = \App\Models\Common\Date::getTip();
            $this->result['login']['tip'] = $tip;
        }
    }

    protected function isLogin($name, $pwd) {
        $result = ['success'=>false, 'msg'=>'登录失败', 'data'=>[]];
        if (!$name || !$pwd) {
            $result['msg'] = '用户名或密码不能为空';
        }
        $userAuth = \App\Models\User\UserAuth::getUserByName($name);
        if (!$userAuth) {
            $result['msg'] = '用户不存在';
        }
        if ($userAuth && $userAuth['certificate'] === md5($this->loginPre.$pwd)) {
            $result['success'] = true;
            $result['msg']= '登录成功';
            $result['data'] = ['uid'=>$userAuth['user_id'], 'name'=>$userAuth['identifier'], 'type'=>$userAuth['identity_type']];
        }
        return $result;
    }
}
