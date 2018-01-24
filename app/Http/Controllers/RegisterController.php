<?php

namespace App\Http\Controllers;
use DB;

class RegisterController extends Controller
{

    const RBNAME = 3;

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
        $nav = config('local')['nav']['register'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['travelInfo' => ''];
        $this->result['myview'] = 'index.register';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function verify() {
        $result = ['success'=>false, 'msg'=>'注册失败','code'=>0, 'data'=>[]];
        $name = trim($_POST['name']);
        $pwd = trim($_POST['pwd']);
        $pwdAgain = trim($_POST['pwdAgain']);
        if (!$name || !$pwd) {
            $result['msg'] = '用户名或密码不能为空';
            $result['code'] = -1;
        }
        if ($pwd != $pwdAgain && !$result['code']) {
            $result['msg'] = '两次输入密码不一致';
            $result['code'] = -2;
        }
        if ((!preg_match("/^[a-z0-9_]*$/i",$pwd) || !preg_match("/^[a-z0-9_]*$/i",$name))  && !$result['code']) {
            $result['msg'] = '用户名或密码只能是数字字母加下划线';
            $result['code'] = -3;
        }
        if ((strlen($name) < 6 || strlen($pwd) < 6)  && !$result['code']) {
            $result['msg'] = '用户名或密码长度必须不小于6位';
            $result['code'] = -4;
        }

        $nameDetail = ($model = \App\Models\User\User::where("user_name", $name)->get()) ? $model->toArray() : array();
        if ($nameDetail  && !$result['code']) {
            $result['msg'] = '该用户名已经被注册'.json_encode($nameDetail);
            $result['code'] = -5;
        }


        if ($result['code'] == 0) {
            // 开始事务
            DB::beginTransaction();
            try {
                $now = date('Y-m-d H:i:s');
                $user = new \App\Models\User\User();
                $user->user_name = $name;
                $user->create_time = $now;
                $user->update_time = $now;
                $user->save();

                $userId = $user->id;
                $userAuth = new \App\Models\User\UserAuth();
                $userAuth->user_id = $userId;
                $userAuth->identity_type = self::RBNAME;
                $userAuth->identifier = $name;
                $userAuth->certificate = md5($this->loginPre.$pwd);
                $userAuth->create_time = $now;
                $userAuth->update_time = $now;
                $userAuth->save();
                $userRegisterLog = new \App\Models\User\UserRegisterLog();
                $userRegisterLog->user_id = $userId;
                $userRegisterLog->register_method = self::RBNAME;
                $userRegisterLog->register_time = $now;
                $userRegisterLog->register_ip = \App\Models\Common\Agent::getIP();
                $userRegisterLog->save();
                // 流程操作顺利则commit
                DB::commit();
                $result['success'] = true;
                $result['msg'] = '恭喜，注册成功';
            } catch (\Exception $E) {
                DB::rollBack();
                //$result['msg'] = $E;
            }
        }
        if ($result['success']) {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2'=>'登录页', 'jumpUrl' => config('local')['website'].'/login'];
        } else {
            $this->result['data'] = ['msg' => $result['msg'], 'msg2'=>'注册页', 'jumpUrl' => config('local')['website'].'/register'];
        }
        $nav = config('local')['nav']['adminTip'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['myview'] = 'index.tip';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }
}
