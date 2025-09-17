<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'topic',
        'start_date',
        'end_date'
    ];

}
