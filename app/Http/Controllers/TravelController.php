<?php

namespace App\Http\Controllers;

class TravelController extends Controller
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

                $travelList[$key]['travelLink'] = config('local')['website'].'/travel/detail/'.$val['id'];
            }
        }
        $this->result['navName'] = config('local')['nav']['travel'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['travelList' => $travelList];
        $this->result['myview'] = 'index.travel.index';
        return view('index.index', $this->result);

    }

    public function detail($id)
    {
        $nav = config('local')['nav']['travel'];
        $page = 1;
        $offset = ($page-1)*$this->limit;
        $travelInfo = \App\Models\Travel\TravelDetail::getInfoById($id, $offset, $this->limit);
        if ($travelInfo) {
            foreach ($travelInfo as $key=>$val) {
                $randImage = \App\Models\Common\Image::randImage();
                $travelInfo[$key]['randImage'] = config('local')['website'].'/static/image/timeline/'.$randImage;
                $travelInfo[$key]['image'] = config('local')['website'] . '/' . $val['image'];
                $travelInfo[$key]['utime'] = date('Y-m-d', strtotime($val['utime']));
            }
        }
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['travelInfo' => $travelInfo, 'limit'=>$this->limit, 'id'=>$id];
        $this->result['myview'] = 'index.travel.detail';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);
    }

    public function more() {
        $result = ['success'=>false, 'code'=>1, 'msg'=>'暂无数据', 'data'=>''];
        $page = isset($_GET['page']) ? $_GET['page'] : 2;
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        if ($page > 1) {
            $offset = ($page - 1) * $this->limit;
            $travelInfo = \App\Models\Travel\TravelDetail::getInfoById($id, $offset, $this->limit);
            if ($travelInfo) {
                foreach ($travelInfo as $key => $val) {
                    $randImage = \App\Models\Common\Image::randImage();
                    $travelInfo[$key]['randImage'] = config('local')['website'].'/static/image/timeline/' . $randImage;
                    $travelInfo[$key]['image'] = config('local')['website'].'/'.$val['image'];
                    $travelInfo[$key]['utime'] = date('Y-m-d', strtotime($val['utime']));
                }
                $result = ['success'=>true, 'code'=>0, 'msg'=>'', 'data'=>$travelInfo];
            }
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function test() {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        header('Access-Control-Allow-Methods:POST');
        sleep(5);
        return 'success';
    }
}
