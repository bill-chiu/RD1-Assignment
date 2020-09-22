<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwoDayModel extends Model
{
    protected $table = 'twoDay';  // 資料表名稱
    public $timestamps = false;
    protected $fillable =   
       ['City','startTime','Wx','WxV','T','RH','PoP','Description','WS','WD'];
}
