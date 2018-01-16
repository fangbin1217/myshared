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
            //setcookie('user_id',$isLogin['data']['uid'],time()+(7200));
            //setcookie('username',$isLogin['data']['name'],time()+(7200));

            //跳转到首页
            header('location:'.config('local')['website'].'/admin');

        } else {
            $nav = config('local')['nav']['login'];
            $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
            $this->result['data'] = ['msg' => $isLogin['msg']];
            $this->result['myview'] = 'index.loginverify';
            $this->result['navName'] = $nav;
            return view('index.index', $this->result);
        }
    }

    public function admin() {
        if (isset($this->result['login']) && $this->result['login']) {
            print_r($this->result['login']);
            echo '登录成功';
        } else {
            echo '登录失败';
        }

    }
}
