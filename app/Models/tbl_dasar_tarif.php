<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_dasar_tarif extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_dasar_tarif';
    protected $table = 'tbl_dasar_tarif';
    protected $connection = 'mysql2';
}
