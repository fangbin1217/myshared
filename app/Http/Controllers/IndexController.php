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

    public function getweatherinfo() {

        $cityName = '';
        $cityCode = '';
        $ip = Agent::getIP();


        $fileName = 'CITY'.ip2long($ip).'.txt';
        $storageLog = $_SERVER['DOCUMENT_ROOT'].'/storage/logs';

        $ipList = explode('.', $ip);

        $weathersPath = $storageLog.'/'.$ipList[0];
        $weathersFile = $weathersPath.'/'.$fileName;


        if (file_exists($weathersFile)) {
            $weathersJson = file_get_contents($weathersFile);
            $cityName = $weathersJson;

        } else {

            $cityUrl = 'http://ip.taobao.com/service/getIpInfo.php?ip=' . '210.75.225.252';
            $cityResult = $this->curl($cityUrl);
            if ($cityResult) {
                $ret = json_decode($cityResult, true);
                if ($ret['code'] == 0 && isset($ret['data']) && $ret['data']) {

                    if (!is_dir($weathersPath)) {
                        mkdir($weathersPath, 0777);
                        chmod($weathersPath, 0777);
                    }
                    $cityName = $ret['data']['city'];
                    $f = fopen($weathersFile, 'w');
                    fwrite($f, $cityName);
                    fclose($f);
                }
            }
        }

        if ($cityName) {
            $cityCodes = json_decode($nav = config('local')['cityCode'], true);
            foreach ($cityCodes as $val) {
                if ($cityName == $val['city_name']) {
                    $cityCode = $val['city_code'];
                    break;
                }
            }
        }

        $path2 = $storageLog.'/'.date('Ymd');
        $wea3 = $path2.'/'.$cityName.'.txt';
        if (file_exists($wea3)) {
            $weathersJson3 = file_get_contents($wea3);
            $myInfo = json_decode($weathersJson3, true);

        } else {
            if ($cityCode) {
                $ret2 = $this->curl('http://t.weather.sojson.com/api/weather/city/' . $cityCode);
                if ($ret2) {
                    $weatherInfoList = json_decode($ret2, true);
                    //print_r($weatherInfoList['data']['forecast']);exit;

                    if ($weatherInfoList && isset($weatherInfoList['data']['forecast']) && $weatherInfoList['data']['forecast']) {
                        $myInfo = $weatherInfoList['data']['forecast'];
                        $weatherInfoJson = json_encode($myInfo, JSON_UNESCAPED_UNICODE);
                        if (!is_dir($path2)) {
                            mkdir($path2, 0777);
                            chmod($path2, 0777);
                        }
                        $f = fopen($wea3, 'w');
                        fwrite($f, $weatherInfoJson);
                        fclose($f);
                    }
                }
            }
        }


        $res = [
            'cityName' => $cityName, 'cityCode' => $cityCode, 'weathers' => $myInfo,
        ];
        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
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
                $familyList[$key]['sourceImage'] = $val['source_image'] ?? $val['image'];
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
