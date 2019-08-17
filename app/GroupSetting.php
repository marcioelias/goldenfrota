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

    public function scopeConfigFTP($query) {
        return $query->where('group_name', 'Conta FTP');
    }

    public function scopeConfigNotificacaoVencimento($query) {
        return $query->where('group_name', 'Notificações');
    }
}
