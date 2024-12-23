<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPic extends Model
{
    use HasFactory;

    protected $table = 'tbl_users_pic'; // Specify the table name

    protected $fillable = ['user_id', 'name', 'path']; // Columns that are mass assignable

    // Optional: If you want to use timestamps, make sure the `created_at` and `updated_at` fields are managed automatically.
    public $timestamps = true;
}
