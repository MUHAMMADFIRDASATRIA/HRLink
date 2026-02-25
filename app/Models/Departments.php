<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'description',
    ];

    public function positions()
    {
        return $this->hasMany(Positions::class, 'department_id');
    }
}
