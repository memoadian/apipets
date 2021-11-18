<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function status () {
        return $this->belongsTo(Status::class);
    }

    public function type () {
        return $this->belongsTo(Type::class);
    }
}
