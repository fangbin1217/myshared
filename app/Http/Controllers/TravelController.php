<?php

namespace App\Http\Controllers;

class TravelController extends Controller
{
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

        $travelInfo = \App\Models\Travel\Travel::getInfoById($id);
        if ($travelInfo) {
            $travelInfo['indexImage'] = config('local')['website'].'/'.$travelInfo['index_image'];
        }
        $this->result['sidebar'] = ['now' =>date('Y-m-d H:i:s', strtotime('-1 days'))];
        $this->result['data'] = ['travelInfo' => $travelInfo];
        $this->result['myview'] = 'index.travel.info';
        $this->result['navName'] = $nav;
        return view('index.index', $this->result);

    }
}
