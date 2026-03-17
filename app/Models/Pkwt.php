<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pkwt extends Model
{
    protected $table = 'pkwt';

    protected $fillable = [
        'user_id',
        'employee_id',
        'contract_number',
        'start_date',
        'end_date',
        'contract_type',
        'work_type',
        'work_type_secondary',
        'base_salary',
        'allowance',
        'total_salary',
        'responsible_name',
        'signed_date',
        'work_location',
        'notes',
        'signed_contract_file',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id');
    }
}
