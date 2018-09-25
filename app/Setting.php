<?php

namespace App;

use App\GroupSetting;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $filleable = [
        'description',
        'key',
        'value',
        'data_type',
        'group_setting_id'
    ];

    public function group_setting() {
        return $this->belongsTo(GroupSetting::class);
    }
}
