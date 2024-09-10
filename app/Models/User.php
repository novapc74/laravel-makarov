<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method static Builder update(array $values)
 * @method static Builder find(int $value)
 * @method static Builder count()
 * @method static Builder paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function partnership(): BelongsTo
    {
        return $this->belongsTo(Partnership::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
