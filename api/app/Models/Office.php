<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $connection = 'dohis';
    protected $table = 'dohis_section';
    protected $primaryKey = 'section_id';
    public $timestamps = false;

    public function personnel()
    {
        return $this->belongsToMany(User::class, 'dohis_user_assignment', 'section_id', 'user_id');
    }
}
