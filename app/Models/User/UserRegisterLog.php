<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserRegisterLog extends Model {

    protected  $table = "user_register_log";

    protected  $primaryKey = "id";

    public $timestamps = false;

}