<?php

namespace App\Modules\Product\Models;

use App\Modules\Center\Models\Center;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function center() {
        return $this->belongsTo(Center::class);
    }
}
