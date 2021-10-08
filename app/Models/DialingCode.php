<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DialingCode extends Model
{
    use HasFactory;

    protected $timestamp = false;

    protected $table = 'dialling_codes';
}
