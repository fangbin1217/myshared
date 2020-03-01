<?php

namespace App\Http\Controllers;
use \App\Models\Article;
class ArticleController extends Controller
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
    public function babystory()
    {

        $dayCounts = app('phpredis')->incr('tbabystoryDayCounts#'.date('Ymd'));
        $totalCounts = app('phpredis')->incr('tbabystoryTotalCounts');
        $isRand = isset($_GET['rand']) ? $_GET['rand'] : '';

        if (!$isRand) {
            $list = ($model = Article::orderBy('id', 'DESC')->offset(0)->limit(1)->get()) ? $model->toArray() : array();
            $list2 = [];
            if ($list) {
                $list2 = $list[0];
            }
        } else {
            $count = Article::count();
            if ($isRand < $count) {
                $isRand++;
            } else {
                $isRand = 1;
            }
            $list2 = Article::find($isRand);
        }
        $this->result['navName'] = config('local')['nav']['articleBabyStory'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>$dayCounts, 'totalCounts' => $totalCounts];
        $this->result['data'] = ['list' => $list2];
        $this->result['myview'] = 'index.article.babystore';
        return view('index.index', $this->result);

    }

    public function study()
    {
        $dayCounts = app('phpredis')->incr('tstudyDayCounts#'.date('Ymd'));
        $totalCounts = app('phpredis')->incr('tstudyTotalCounts');
        $this->result['navName'] = config('local')['nav']['articleStudy'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>$dayCounts, 'totalCounts' => $totalCounts];
        $this->result['myview'] = 'index.article.study';

        $mymenu = [];
        $menu = config('local')['menu'];
        foreach ($menu as $val) {
            $tmp = $val;
            $tmp['image'] =  config('local')['website'].'/static/image/label'.rand(1,4).'.png';
            $mymenu[] =$tmp;
        }
        $this->result['data'] = ['list' => $mymenu];

        return view('index.index', $this->result);

    }

    public function detail($id) {
        $dayCounts = app('phpredis')->incr('tnavDayCounts#'.date('Ymd'));
        $totalCounts = app('phpredis')->incr('tnavTotalCounts');
        $this->result['navName'] = config('local')['nav']['articleStudy'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days')), 'dayCounts'=>$dayCounts, 'totalCounts' => $totalCounts];
        $this->result['myview'] = 'index.article.detail';

        if ($id === '1.html') {
            $this->result['header']['title2'] = 'QQ小程序实现大转盘抽奖----踩坑之路 - 花好月圆';
            $this->result['header']['keywords2'] = 'QQ小程序,小程序抽奖,大转盘抽奖';
            $this->result['header']['description2'] = '现在有一个小程序抽奖页面如下，此类抽奖方式为大转盘 思路：由服务器获取可抽奖次数和奖品，根据服务器返回的数据来决定转盘指针的位置..'; 

        }
        

        $this->result['data'] = ['detail' => ['id'=>$id]];

        return view('index.index', $this->result);

    }

}
