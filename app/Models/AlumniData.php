<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniData extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'studentNumber',
        'civilStatus',
        'year',
        'relatedOrNot',
        'course',
        'employmentStatus',
        'gender',
        'email',
        'employmentType'
    ];
}
