<?php

namespace App\Http\Controllers;
use App\Models\City;
class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function test() {
        exit;
        $idd = 65;
        $a = City::whereRaw("code like '$idd%'")->get();
        $b = $a->toArray();

        $ss = [];
        foreach ($b as $z) {
            if (substr($z['code'], 4, 2) == '00' && $z['p_id'] != 0) {
                $ss[] = $z;
            }
            //exit;
        }
        //print_r($ss);exit;
        foreach ($b as $c) {
            if (substr($c['code'], 4, 2) != '00' && $c['p_id'] != 0) {
                foreach ($ss as $tt) {
                    if (substr($tt['code'], 0, 4) == substr($c['code'], 0, 4)) {
                        $pid = $tt['id'];
                        $id = $c['id'];
                        City::whereRaw("id = $id")->update(['p_id' => $pid]);
                        //exit;
                        break;
                    }
                }
            }
            //exit;
        }

        print_r($b);

        exit;
        $ret = $this->getCurl(['dest'=>'http://www.stats.gov.cn/tjsj/tjbz/xzqhdm/201703/t20170310_1471429.html']);
        //print_r($ret);exit;
        $html = $ret['data'];
        $regular = '//div[@class="TRS_PreAppend"]//p[@class="MsoNormal"]';
        $a = $this->getXpath($html, $regular);
        $c = [];

        foreach ($a as $k=>$b) {
            $tmp = explode(" ", $b);
            if (!preg_match('#市辖区#', $tmp[1])) {
                $d = ['ss' => trim($tmp[0]), 'tt' => trim($tmp[1])];
                preg_match('#\d+#', $d['ss'], $match1);
                $d['ss'] = $match1[0];
                //print_r($match1);exit;
                preg_match('#[\x{4e00}-\x{9fa5}]+#u', $d['tt'], $match2);
                $d['tt'] = $match2[0];
                $ccc = City::insert(['code'=>$d['ss'],'city'=>$d['tt']]);
                //print_r($ccc);
                print_r($d);
                echo strlen($d['ss']).'|'.strlen($d['tt']);
                if ($k>=10) {

                    //exit;
                }


            }
        }
        print_r($c);
    }

    /**
     * html的解析
     * @param  $data
     * @param  $string
     * @return array
     */
    private function getXpath($data, $string)
    {
        $results = array();
        if ($data) {
            libxml_use_internal_errors(true);
            $doc = new \DomDocument ();
            $doc->loadHTML($data);
            $xpath = new \DOMXpath ($doc);
            $nodes = $xpath->query($string);
            foreach ($nodes as $node) {
                $nodeValue = $node->nodeValue;
                $nodeValue = $this->nodeSweep($nodeValue);
                $results [] = $nodeValue;
            }
        }
        return $results;
    }

    /**
     * 解析的编码转换
     * @param  $nodeValue
     * @return string
     */
    private function nodeSweep($nodeValue)
    { // 清除多余的空白内容
        $nodeValue = mb_convert_encoding($nodeValue, "HTML-ENTITIES", "utf-8"); // 转化为HTML格式字符
        $nodeValue = preg_replace('/\s(?=\s)/', '', $nodeValue); // 删除多余的空格
        $nodeValue = str_replace("\r\n", "", $nodeValue); // 删除换行
        $nodeValue = str_replace("\t", '', $nodeValue); // 删除制表符
        $nodeValue = str_replace("&nbsp;", "", $nodeValue); // 删除中文空格符
        $nodeValue = trim($nodeValue);
        $nodeValue = mb_convert_encoding($nodeValue, "utf-8", "HTML-ENTITIES"); // 转化为原来
        return $nodeValue;
    }

    /**
     * CURL请求
     * @param  $request
     * @return array
     */
    private function getCurl($request){
        $ch = curl_init ( $request ['dest'] );
        //curl_setopt ( $ch, CURLOPT_REFERER, $request['referer']);
        //curl_setopt ( $ch, CURLOPT_HTTPHEADER, $request ['headers'] );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        //curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $request ['timeouts'] );
        //curl_setopt ( $ch, CURLOPT_TIMEOUT, $request ['timeouts'] );
        //curl_setopt ( $ch, CURLOPT_HEADER, $request ['header'] );
        if (isset($request ['proxy']) && !empty($request['proxy'])) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
            curl_setopt($ch, CURLOPT_PROXY, $request ['proxy']); //代理服务器地址
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式
        }
        if(isset($request ['cookie'])) {
            if (strpos ( $request ['cookie'], '=' )) {
                curl_setopt ( $ch, CURLOPT_COOKIE, $request ['cookie'] );
            } elseif (isset($request ['cookie_file'])) {
                curl_setopt ( $ch, CURLOPT_COOKIEFILE, $request ['cookie_file'] );
            }
        }
        if (isset($request ['cookie_jar'])) {
            curl_setopt ( $ch, CURLOPT_COOKIEJAR, $request ['cookie_jar'] );
        }
        if (isset($request ['gzip'])) {
            curl_setopt ( $ch, CURLOPT_ENCODING, 'gzip' );
        }
        if (isset($request ['postdata'])) {
            curl_setopt ( $ch, CURLOPT_POST, 1 );
            if (is_array($request['postdata'])){
                $request['postdata'] = http_build_query($request ['postdata']);
            }
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $request ['postdata'] );
        }
        if (isset($request ['username']) && isset($request ['password'])) {
            curl_setopt ( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
            curl_setopt ( $ch, CURLOPT_USERPWD, $request ['username'] . ':' . $request ['password'] );
        }
        $data = curl_exec ( $ch );
        $error = curl_error($ch);
        $info = curl_getinfo ( $ch );
        curl_close ( $ch );

        return array (
            'httpcode' => $info ['http_code'],
            'totaltime' => isset($info ['total_time']) ? $info ['total_time'] : 0,
            'data' => $data,
            'error' => $error
        );
    }
}
