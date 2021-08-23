<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignModel extends Model
{
    use HasFactory;
    protected $table = 'asigns';
    protected $primary_key = 'id';
}
