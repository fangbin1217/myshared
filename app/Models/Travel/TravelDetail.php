<?php
namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;

class TravelDetail extends Model {

    protected  $table = "travel_detail";

    protected  $primaryKey = "id";

    public $timestamps = false;


    static public function getInfoById($id, $offset, $limit = 5, $state = 0) {
        return ($model = TravelDetail::where("state", $state)->where("travel_id", $id)->offset($offset)->limit($limit)->orderBy('utime', 'ASC')->get()) ? $model->toArray() : array();
    }
}