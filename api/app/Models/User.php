<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $connection = 'dohis';
    protected $table = 'dohis_user';
    protected $primaryKey = 'user_id';

    public function assignment()
    {
        return $this->hasOne(UserAssignment::class,'user_id');
    }

    public function permissions()
    {
        
    }

    public function properties()
    {
        return $this->hasMany(PropertyUser::class,'user_id');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class,'end_user');
    }

}
