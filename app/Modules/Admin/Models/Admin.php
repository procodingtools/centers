<?php

namespace App\Modules\Admin\Models;

use App\Models\AdminsCenter;
use App\Modules\Center\Models\Center;
use App\Modules\Training\Models\Training;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function centers() {
        return $this->belongsToMany(Center::class, 'admins_centers');
    }


    public function hasCenter($id) {
        $adminId = Admin::whereUserId(Auth::id())->get()->first()->id;
        $centers = AdminsCenter::whereAdminId($adminId)->whereCenterId($id)->get();
        return $centers->isNotEmpty();
    }


    public function trainings() {
        return $this->belongsToMany(Training::class, 'admins_trainings');
    }
}
