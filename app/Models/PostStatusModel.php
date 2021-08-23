<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostStatusModel extends Model
{
    use HasFactory;
    protected $table = 'post_status';
    protected $primary_key = 'id';
}
