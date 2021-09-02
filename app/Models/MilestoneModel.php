<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilestoneModel extends Model
{
    use HasFactory;
    protected $table = 'milestones';
    protected $primaryKey = 'id';
}
