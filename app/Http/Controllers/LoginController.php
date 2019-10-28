<?php

namespace App\Http\Controllers;

class LoginController extends Controller
{

    public function __construct() {
        parent::__contract();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $nav = config('local')['nav']['login'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['travelInfo' => ''];
        $this->result['myview'] = 'index.login';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);

    }

    public function verify() {
        $isLogin = $this->isLogin($_POST['name'], $_POST['pwd']);
        if ($isLogin['success']) {
            $_SESSION['UID']=$isLogin['data']['uid'];
            $_SESSION['UNAME']=$isLogin['data']['name'];
            /*****记录登录信息******/
            try {
                $userLoginLog = new \App\Models\User\UserLoginLog();
                $userLoginLog->user_id = $_SESSION['UID'];
                $userLoginLog->type = $isLogin['data']['type'];
                $userLoginLog->login_type = 1;
                $getIP = \App\Models\Common\Agent::getIP();
                $userLoginLog->lastip = $getIP;
                $userLoginLog->user_agent = $_SERVER['HTTP_USER_AGENT'];
                $userLoginLog->create_time = date('Y-m-d H:i:s');
                $userLoginLog->save();
            } catch (\Exception $E) {
                //
            }
            //header('location:'.config('local')['website'].'/admin');
            $this->result['data'] = ['msg' => '登录成功', 'msg2'=>'后台首页', 'jumpUrl' => config('local')['website'].'/admin'];

        } else {
            $this->result['data'] = ['msg' => '登录失败', 'msg2'=>'登录页', 'jumpUrl' => config('local')['website'].'/login'];
        }

        $nav = config('local')['nav']['adminTip'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['myview'] = 'index.tip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function loginout() {

        /*****记录登录信息******/
        try {
            $userLoginLog = new \App\Models\User\UserLoginLog();
            $userLoginLog->user_id = $_SESSION['UID'];
            $userLoginLog->type = 3;
            $userLoginLog->login_type = 2;
            $getIP = \App\Models\Common\Agent::getIP();
            $userLoginLog->lastip = $getIP;
            $userLoginLog->user_agent = $_SERVER['HTTP_USER_AGENT'];
            $userLoginLog->create_time = date('Y-m-d H:i:s');
            $userLoginLog->save();
        } catch (\Exception $E) {
            //
        }
        /*** 删除所有的session变量..也可用unset($_SESSION[xxx])逐个删除。****/
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();

        $nav = config('local')['nav']['adminTip'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['msg' => '退出成功', 'msg2'=>'首页', 'jumpUrl' => config('local')['website'].'/'];
        $this->result['myview'] = 'index.tip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);

    }

    public function test() {
        $a = \App\Models\User\User::getUserByIds();
        print_r($a);exit;
        echo 'test';exit;
    }
}
