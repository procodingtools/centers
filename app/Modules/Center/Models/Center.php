<?php

namespace App\Modules\Center\Models;

use App\Modules\Actuality\Models\Actuality;
use App\Modules\Admin\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function actualities() {
        return $this->hasMany(Actuality::class);
    }

    public function admins() {
        return $this->belongsToMany(Admin::class, 'admins_centers');
    }
}
