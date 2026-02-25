<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = 'positions';

    protected $fillable = [
        'title',
        'department_id',
        'description',
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function employees()
    {
        return $this->hasMany(Employees::class, 'position_id');
    }
}
