<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;


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


    /**
     * @return BelongsTo
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }


    /**
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_book', 'book_id', 'author_id')->withTimestamps();
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeSearch($query): mixed
    {
        return $query->when(request('search'), function ($query) {
            $search = strtolower(request('search'));
            $query->where(DB::raw("lower(title)"), 'LIKE', "%$search%")
                ->orWhere(DB::raw("lower(description)"), 'LIKE', "%$search%");
        });
    }
}
