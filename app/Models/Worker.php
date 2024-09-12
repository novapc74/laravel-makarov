<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use phpseclib3\Crypt\Hash;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method static Builder update(array $values)
 * @method static Builder find(int $value)
 * @method static Builder count()
 * @method static Builder paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
 */
class Worker extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'second_name',
        'surname',
        'phone'
    ];

    public function orderWorkers(): HasMany
    {
        return $this->hasMany(OrderWorker::class);
    }

    public function workerExOrderTypes(): HasMany
    {
        return $this->hasMany(WorkerExOrderType::class);
    }
}
