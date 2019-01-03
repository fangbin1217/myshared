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
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['list' => $list2];
        $this->result['myview'] = 'index.article.babystore';
        return view('index.index', $this->result);

    }

    public function study()
    {

        $this->result['navName'] = config('local')['nav']['articleStudy'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
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

    public function nav($id) {
        $this->result['navName'] = config('local')['nav']['articleStudy'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['myview'] = 'index.article.nav';


        $mymenu = [];
        $menu = config('local')['menu'];
        foreach ($menu as $val) {
            if ($val['id'] == $id) {
                $mymenu = $val;
                break;
            }
        }

        if (!$mymenu) {
            header('Location:'.config('local')['website'].'/article/study');exit;
        }
        $this->result['navName'] .= ' > '.$mymenu['name'];
        $list = [];
        if (isset(config('local')[$mymenu['name']])) {
            $list = config('local')[$mymenu['name']];
            foreach ($list as $key=> $val) {
                $tmp = $val;
                $tmp['image'] =  config('local')['website'].'/static/image/label'.rand(1,4).'.png';
                $list[$key] =$tmp;
            }
        }

        $this->result['data'] = ['list' => $list];

        return view('index.index', $this->result);

    }

    public function detail($id) {
        $this->result['navName'] = config('local')['nav']['articleStudy'];
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['myview'] = 'index.article.detail';


        if (!isset(config('local')['ARTICLE'.$id])) {
            header('Location:'.config('local')['website'].'/article/study');exit;
        }
        $mymenu = config('local')['ARTICLE'.$id];

        $this->result['navName'] .= ' > '.$mymenu['name'];
        $list = [];
        $list = $mymenu['detail'];
        $this->result['data'] = ['list' => $list];

        return view('index.index', $this->result);
    }
}
