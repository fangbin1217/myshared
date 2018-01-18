<?php

namespace App\Http\Controllers;

class AdminController extends Controller
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

        if ($this->result['login']) {

            $tip = '晚上好';
            if (in_array(date('H'), ['06','07','08','09','10','11','12'])) {
                $tip = '上午好';
            } else if (in_array(date('H'), ['13','14','15','16','17','18'])) {
                $tip = '下午好';
            }

            $nav = config('local')['nav']['admin'];
            $this->result['sidebar'] = ['now' => date('Y-m-d H:i:s', strtotime('-1 days'))];
            $this->result['data'] = ['travelInfo' => '', 'loginInfo'=> $this->result['login'], 'tip'=>$tip];
            $this->result['myview'] = 'index.admin';

            $this->result['navName'] = $nav;
            return view('index.index', $this->result);
        } else {
            //跳转到login
            header('location:'.config('local')['website'].'/login');
        }

    }

    public function addbaby() {
        if ($this->result['login']) {

            $tip = '晚上好';
            if (in_array(date('H'), ['06','07','08','09','10','11','12'])) {
                $tip = '上午好';
            } else if (in_array(date('H'), ['13','14','15','16','17','18'])) {
                $tip = '下午好';
            }

            $nav = config('local')['nav']['adminAddBaby'];
            $this->result['sidebar'] = ['now' => date('Y-m-d H:i:s', strtotime('-1 days'))];
            $this->result['data'] = ['travelInfo' => '', 'loginInfo'=> $this->result['login'], 'tip'=>$tip];
            $this->result['myview'] = 'index.admin.addbaby';

            $this->result['navName'] = $nav;
            return view('index.index', $this->result);
        } else {
            //跳转到login
            header('location:'.config('local')['website'].'/login');
        }
    }
}
