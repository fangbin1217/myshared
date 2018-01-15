<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    protected $result = [];

    protected $modelCommon = ['header'=>[], 'sidebar'=>[], 'footer'=>[], 'myview'=>'', 'data'=>[]];

    public function __contract() {
        $this->result = $this->modelCommon;
    }
}
