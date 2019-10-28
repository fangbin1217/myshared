<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected  $table = "user";

    protected  $primaryKey = "id";

    public $timestamps = false;

    /**
     * 根据城市获取限行规则
     * @param $city string 城市名
     * @return array
     */
    static public function getUserById($id) {
        return ($model = User::where("id", $id)->get()) ? $model->toArray() : array();
    }

    //static public function getUserByIds($id = 1738) {
       // return ($model = User::where("id", $id)->get()) ? $model->toArray() : array();
    //}
}