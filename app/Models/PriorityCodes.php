<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriorityCodes extends Model
{
    use HasFactory;
    protected $table = 'priority_codes';
    protected $primaryKey = 'id';
}
