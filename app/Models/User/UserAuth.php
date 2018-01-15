<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserAuth extends Model {

    protected  $table = "user_auth";

    protected  $primaryKey = "id";

    //public $timestamps = false;

    /**
     * 根据城市获取限行规则
     * @param $city string 城市名
     * @return array
     */
    static public function getUserByName($name, $identity_type = 3) {
        return ($model = UserAuth::where("identifier", $name)->where("identity_type", $identity_type)->first()) ? $model->toArray() : array();
    }
}