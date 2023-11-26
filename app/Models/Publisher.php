<?php

namespace App\Models;

use App\Casts\Phone;
use App\Contracts\Interfaces\HasBooksInterface;
use App\Contracts\Interfaces\HasPhoneInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Traits\HasBooks;
use App\Contracts\Traits\HasPhone;
use App\Contracts\Traits\ModelName;
use App\Contracts\Traits\UserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Publisher extends Authenticatable implements MustVerifyEmail, HasPhoneInterface, HasBooksInterface, UserInterface
{
    use HasFactory, HasApiTokens, Notifiable, HasPhone, HasBooks, ModelName, UserTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'email',
        'phone'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'phone' => Phone::class,
    ];
}
