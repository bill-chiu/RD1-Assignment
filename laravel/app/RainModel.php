<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RainModel extends Model
{
    protected $table = 'rain';  // 資料表名稱
    public $timestamps = false;
    protected $fillable =   
       ['city','town','townName','attribute','oneHour','oneDay'];
}
