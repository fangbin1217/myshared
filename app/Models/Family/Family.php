<?php
namespace App\Models\Family;

use Illuminate\Database\Eloquent\Model;

class Family extends Model {

    protected  $table = "family";

    protected  $primaryKey = "id";

    //public $timestamps = false;

    /**
     * 根据城市获取限行规则
     * @param $city string 城市名
     * @return array
     */
    static public function getList($offset, $limit = 5, $state = 0) {
        return ($model = Family::where("state", $state)->offset($offset)->limit($limit)->orderBy('utime','DESC')->get()) ? $model->toArray() : array();
    }
}