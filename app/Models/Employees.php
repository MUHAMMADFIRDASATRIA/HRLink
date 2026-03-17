<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'location_of_birth',
        'agama',
        'marital_status',
        'date_of_birth',
        'education',
        'position_id',
        'department_id',
        'user_id',
    ];

    public function position()
    {
        return $this->belongsTo(Positions::class, 'position_id');
    }
}
