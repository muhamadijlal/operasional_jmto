<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_penerbitan_kartu extends Model
{
    use HasFactory;

    protected $table = 'tbl_penerbitan_kartu';
    protected $guarded = ['id'];
    protected $connection = 'mysql';
    public $timestamps = false;
}
