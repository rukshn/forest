<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostStatusCodeModel extends Model
{
    use HasFactory;
    protected $table = 'status_codes';
    protected $primary_key = 'id';
}
