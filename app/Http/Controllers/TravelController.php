<?php

namespace App\Http\Controllers;

class TravelController extends Controller
{
    private $limit = 3;

    public function __construct() {
        parent::__contract();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index($id)
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

    public function detail($id)
    {

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
}
