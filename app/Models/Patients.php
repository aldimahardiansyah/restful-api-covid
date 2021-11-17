<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    // medefinisikan property fillable untuk menggunakan mass asignment
    protected $fillable = ['name', 'phone', 'address', 'status_id'];

    # membuat relation one to many dari table patients ke table history
    public function history()
    {
        return $this->hasMany(history::class);
    }

    # membuat relation reverse one to one ke tabel status
    public function status()
    {
        return $this->belongsTo(status::class);
    }
}
