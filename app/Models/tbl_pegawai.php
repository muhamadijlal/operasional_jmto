<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class tbl_pegawai extends Model implements Authenticatable
{
    use AuthenticableTrait;

    protected $table = 'tbl_pegawai';
}
