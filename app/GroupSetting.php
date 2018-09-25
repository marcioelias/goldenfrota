<?php

namespace App;

use App\Setting;
use Illuminate\Database\Eloquent\Model;

class GroupSetting extends Model
{
    protected $fillable = [
        'group_name'
    ];

    public function settings() {
        return $this->hasMany(Setting::class);
    }
}
