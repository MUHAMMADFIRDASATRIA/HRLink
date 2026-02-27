<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function positions()
    {
        return $this->hasMany(Positions::class, 'department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
