<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_tarif extends Model
{
    use HasFactory;

    protected $table = 'view_tarif';
    protected $connection = 'mysql2';
    public $timestamps = false;
}
