<?php

// app/Models/Profile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
 
    protected $primaryKey ='profile_id';
    protected $table = 'tbl_profile'; // Ensure this matches your table name
    protected $fillable = [
        'user_id',
        'address',
        'phone',
        'city',
        'state',
        'country',
        'ip_address',
        'created_on',
        'modified_on',
    ];
    public  $timestamps =false;

    // Profile belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
