<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class status extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    # membuat relation one to many ke tabel patients
    public function patients()
    {
        return $this->hasMany(Patients::class);
    }
}
