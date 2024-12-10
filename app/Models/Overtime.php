<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $table = 'overtimes';
    protected $primaryKey = 'overtime_id';

    protected $fillable = [
        'Overtime_Type',
        'Rate_Per_Hour',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'overtime_id');
    }
}
