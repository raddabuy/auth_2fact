<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function phoneNumber(){
        return $this->hasOne(NumberPhone::class);
    }

    public function hasTwoFactorType($type)
    {
        return $this->two_factor_type === $type;
    }

    public function hasDiallingCode($diallingCodeId)
    {
        if ($this->hasPhoneNumber() === false) {
            return false;
        }

        return $this->phoneNumber->diallingCode->id === $diallingCodeId;
    }

    public function hasTwoTactorAuthenticztionEnabled()
    {
        return $this->two_factor_type !== 'off';
    }

    public function hasSmsTwoTactorAuthenticztionEnabled()
    {
        return $this->two_factor_type === 'sms';
    }

    public function registeredForTwoFactorAuthentication()
    {
        return $this->authy_id !== null;
    }

    public function updatePhoneNumber($phoneNumber, $phoneNumberDiallingCode)
    {
        $this->phoneNumber()->delete();

        if (!$phoneNumber) {
            return;
        }

        return $this->phoneNumber()->create([
            'phone_number' => $phoneNumber,
            'dialling_code_id' => $phoneNumberDiallingCode,
        ]);
    }

    public function hasPhoneNumber()
    {
        return $this->phoneNumber !== null;
    }


    public function getPhoneNumber()
    {
        if ($this->hasPhoneNumber() === false) {
            return false;
        }

        return $this->phoneNumber->phone_number;
    }

}
