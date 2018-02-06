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
}
