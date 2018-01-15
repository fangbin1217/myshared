<?php

namespace App\Http\Controllers;

/**
 * 首页入口
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{

    private $limit = 5;

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
        $travelList = \App\Models\Travel\Travel::getList();
        if ($travelList) {
            foreach ($travelList as $key=>$val) {
                $travelList[$key]['tagName'] = '';
                $travelList[$key]['content'] = mb_substr($val['content'], 0, 70, 'utf-8').'..';

                if (isset(config('local')['travel_tag'][$val['tag']])) {
                    $travelList[$key]['tagName'] = config('local')['travel_tag'][$val['tag']];
                }

                $travelList[$key]['indexImage'] = config('local')['website'].'/'.$val['index_image'];

                $travelList[$key]['utime'] = \App\Models\Common\Date::getDateToString($val['utime']);

                $travelList[$key]['travelLink'] = config('local')['website'].'/travel/index/'.$val['id'];
            }
        }
        //$user = User::getUserById(1);
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['travelList' => $travelList];
        $this->result['myview'] = 'index.index.welcome';
        return view('index.index', $this->result);

    }

    public function resume()
    {
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        //$this->result['data'] = ['article1'=>'杭州西湖'];
        $this->result['myview'] = 'index.about.resume';
        $this->result['navName'] = config('local')['nav']['resume'];
        return view('index.index', $this->result);
    }


    public function baby() {
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $page = 1;
        $offset = ($page-1)*$this->limit;
        $familyList = \App\Models\Family\Family::getList($offset, $this->limit);
        if ($familyList) {
            foreach ($familyList as $key=>$val) {
                $randImage = \App\Models\Common\Image::randImage();
                $familyList[$key]['randImage'] = 'static/image/timeline/'.$randImage;
                $familyList[$key]['utime'] = date('Y-m-d', strtotime($val['utime']));
            }
            $this->result['data'] = ['familyList' => $familyList, 'limit'=>$this->limit];
        }

        $this->result['myview'] = 'index.about.baby';
        $this->result['navName'] = config('local')['nav']['baby'];
        return view('index.index', $this->result);
    }

    public function more() {
        $result = ['success'=>false, 'code'=>1, 'msg'=>'暂无数据', 'data'=>''];
        $page = isset($_GET['page']) ? $_GET['page'] : 2;
        if ($page > 1) {
            $offset = ($page - 1) * $this->limit;
            $familyList = \App\Models\Family\Family::getList($offset, $this->limit);
            if ($familyList) {
                foreach ($familyList as $key => $val) {
                    $randImage = \App\Models\Common\Image::randImage();
                    $familyList[$key]['randImage'] = 'static/image/timeline/' . $randImage;
                    $familyList[$key]['utime'] = date('Y-m-d', strtotime($val['utime']));
                }
                $result = ['success'=>true, 'code'=>0, 'msg'=>'', 'data'=>$familyList];
            }
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
