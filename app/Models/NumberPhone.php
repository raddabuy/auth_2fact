<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberPhone extends Model
{
    use HasFactory;

    protected $table = 'phone_numbers';

    protected $fillable = ['phone_number', 'dialling_code_id', 'user_id'];

    public function diallingCode(){
        return $this->hasOne(DialingCode::class,'id','dialling_code_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
