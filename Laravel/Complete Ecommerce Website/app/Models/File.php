<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // Specify the table name explicitly
    protected $primaryKey ='id';
    protected $table = 'tbl_file';

    // Specify the fillable columns for mass assignment
    protected $fillable = [
        'filename',
        'size',
        'folder',
        'user_id',
        'status',
        'created_on',
        'modified_on',
    ];
    public  $timestamps =false;

    // Define a relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}