<?php

namespace App\Models;

use App\Casts\Phone;
use App\Contracts\Interfaces\HasBooksInterface;
use App\Contracts\Interfaces\HasPhoneInterface;
use App\Contracts\Traits\HasBooks;
use App\Contracts\Traits\HasPhone;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Author extends Authenticatable implements MustVerifyEmail, HasPhoneInterface, HasBooksInterface
{
    use HasFactory, HasApiTokens, Notifiable, HasPhone, HasBooks;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'phone' => Phone::class,
    ];
}
