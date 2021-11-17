<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history extends Model
{
    use HasFactory;

    protected $fillable = ['in_date_at', 'out_date_at', 'patients_id'];

    # membuat relation reverse ke tabel patients
    public function patients()
    {
        return $this->belongsTo(Patients::class);
    }
}
