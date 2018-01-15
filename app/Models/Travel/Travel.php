<?php
namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model {

    protected  $table = "travel";

    protected  $primaryKey = "id";

    //public $timestamps = false;

    /**
     * 根据城市获取限行规则
     * @param $city string 城市名
     * @return array
     */
    static public function getList($state = 0) {
        return ($model = Travel::where("state", $state)->get()) ? $model->toArray() : array();
    }

    static public function getInfoById($id, $state = 0) {
        return ($model = Travel::where("state", $state)->find($id)) ? $model->toArray() : array();
    }
}