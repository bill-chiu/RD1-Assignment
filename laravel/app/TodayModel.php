<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TodayModel extends Model
{
    protected $table = 'today';  // 資料表名稱
    public $timestamps = false;
    protected $fillable =   
       ['Wx','WxV','MaxT','MinT','PoP'];
}