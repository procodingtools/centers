<?php

namespace App\Modules\Appointment\Models;

use App\Modules\Admin\Models\Admin;
use App\Modules\Client\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}
