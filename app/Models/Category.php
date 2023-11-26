<?php

namespace App\Models;

use App\Contracts\Interfaces\HasBooksInterface;
use App\Contracts\Traits\HasBooks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements HasBooksInterface
{
    use HasFactory, HasBooks;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'title' => 'string',
        'description' => 'string',
    ];
}
