<?php

namespace App\Http\Controllers;
use App\Models\Common\Agent;

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
        $city = '';
        $ip = Agent::getIP();
        $cityUrl = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json';
        $cityResult = $this->curl($cityUrl);
        if ($cityResult) {
            $cityList = @json_decode($cityResult , true);
            if ($cityList && isset($cityList['city'])) {
                $city = $cityList['city'];
            }
        }
        //$city = '北京';
        $weathers = [];
        if ($city) {

            $url = 'http://www.sojson.com/open/api/weather/json.shtml?city='.$city;
            $result = $this->curl($url);
            if ($result) {
                $datasList = @json_decode($result, true);
                if ($datasList['status'] == 200 && isset($datasList['data']['forecast'])) {
                    $weathers = $datasList['data']['forecast'];
                }
            }

        }


        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['IP' => $ip, 'myCity'=>$city, 'weathers' => $weathers];
        $this->result['myview'] = 'index.index.welcome';
        return view('index.index', $this->result);

    }

    public function resume()
    {
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['myview'] = 'index.about.resume';
        $this->result['navName'] = config('local')['nav']['resume'];
        return view('index.index', $this->result);
    }


    public function baby() {
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $page = 1;
        $offset = ($page-1)*$this->limit;
        if ($this->result['login'] && $this->result['login']['isAdmin']) {
            $familyList = \App\Models\Family\Family::getList($offset, $this->limit);
        } else {
            $where = [];
            $where['is_private'] = 0;
            $familyList = \App\Models\Family\Family::getList($offset, $this->limit, $where);
        }
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
            if ($this->result['login'] && $this->result['login']['isAdmin']) {
                $familyList = \App\Models\Family\Family::getList($offset, $this->limit);
            } else {
                $where = [];
                $where['is_private'] = 0;
                $familyList = \App\Models\Family\Family::getList($offset, $this->limit, $where);
            }
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

    private function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.weather.com.cn/forecast/index.shtml');//必须滴
        //curl_setopt($ch, CURLOPT_COOKIE,'isexist=1');//最好带上 比较稳定
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
