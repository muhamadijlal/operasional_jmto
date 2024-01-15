<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pegawai2 extends Model
{
    use HasFactory;

    protected $table = 'tbl_pegawai';
    protected $connection = 'mysql2';
    public $timestamps = false;
}
