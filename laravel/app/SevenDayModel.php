<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SevenDayModel extends Model
{
    protected $table = 'sevenDay';  // 資料表名稱
    public $timestamps = false;
    protected $fillable =   
       ['startTime','Wx','WxV','MaxAT','MinAT','MaxT','MinT','PoP','Description','WS','WD'];
}
