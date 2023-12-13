<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_tarif_open extends Model
{
    use HasFactory;

    protected $table = 'tbl_tarif_open';
    protected $connection = 'mysql2';
    public $timestamps = false;
}
