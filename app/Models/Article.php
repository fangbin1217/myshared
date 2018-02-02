<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    protected  $table = "article";

    protected  $primaryKey = "id";

    public $timestamps = false;

    static public function getArticleById($id) {
        return ($model = Article::where("id", $id)->get()) ? $model->toArray() : array();
    }

}