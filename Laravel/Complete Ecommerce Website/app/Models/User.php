<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $timestamps = false;
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function profile2()
    {
        return $this->hasOne(Profile2::class, 'user_id');
    }
    public function pic()
    {
        return $this->hasOne(UserPic::class, 'user_id');
    }
    public function document()
    {
        return $this->hasOne(File::class, 'user_id');
    }

    public function scopeSearch($query, $nameQuery, $emailQuery)
{
    return $query
        ->where('status', 1)
        ->where('name', 'like', "%$nameQuery%")
        ->where('email', 'like', "%$emailQuery%");
}
    
    public function scopeFileExists($query)
    {
        return $query->addSelect([
            'fileExists' => User::selectRaw('
            CASE 
                WHEN EXISTS (
                    SELECT 1 
                    FROM uploads 
                    WHERE user_id = users.id AND file_name LIKE ?
                ) THEN 1 ELSE 0 END', ['%.pdf']) 
        ]);
    }

    public function hasFile($extensions = ['pdf', 'docx', 'doc'])
    {
        foreach ($extensions as $extension) {
            $filePath = base_path("uploads/{$this->id}/{$this->id}.{$extension}");
            if (file_exists($filePath)) {
                return [
                    'fileExists' => true,
                    'fileName' => "{$this->id}.{$extension}"
                ];
            }
        }
        return ['fileExists' => false, 'fileName' => ''];
    }
}
