<?php

namespace App\Modules\Training\Models;

use App\Modules\Admin\Models\Admin;
use App\Modules\Center\Models\Center;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function center() {
        return $this->belongsTo(Center::class);
    }


    public function admins() {
        return $this->belongsToMany(Admin::class, 'admins_trainings')->withPivot(['granted', 'present']);
    }
}
