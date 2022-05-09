<?php

namespace App\Modules\Documentation\Models;

use App\Modules\Center\Models\Center;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function center() {
        return $this->belongsTo(Center::class);
    }
}
