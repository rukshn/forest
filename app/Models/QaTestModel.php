<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QaTestModel extends Model
{
    use HasFactory;
    protected $table = "qatests";
    protected $primary_key = "id";
}
