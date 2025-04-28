<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $connection = 'dohis';
    protected $table = 'dohis_designation';
    public $timestamps = false;

    protected $primaryKey = 'designation_id';
}
