<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;
    use Filterable;

    protected $with = ['replies'];
    protected $fillable = ['username', 'email', 'url', 'body', 'file', 'parent_id'];

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * This method control default order
     * @param Builder $builder
     * @return void
     */
    public static function setDefaultCommentsSort(Builder $builder): void
    {
        $builder->orderBy('created_at');
    }
}
