<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class CateModel extends Model
{
    public $table="news_cate";
    public $primaryKey='cate_id';
    public $timestamps=false;
}
