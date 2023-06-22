<?php


namespace App\Http\Filters;


use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;

class CommentFilter extends AbstractFilter
{
    public const SORT = 'sort';
    public const ALLOWED_SORT_BY = [
        'created_at', 'created_at,desc',
        'email', 'email,desc',
        'username', 'username,desc'
    ];

    protected function getCallbacks(): array
    {
        return [
            self::SORT => [$this, 'sort'],
        ];
    }

    /**
     *
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function sort(Builder $builder, $queryValue)
    {
        if (!in_array($queryValue, self::ALLOWED_SORT_BY)) {
            Comment::setDefaultCommentsSort($builder);
            return;
        }

        $queryValueParts = explode(",", $queryValue);

        if (isset($queryValueParts[1])) {
            if (in_array('desc', $queryValueParts)) {
                $builder->orderByDesc($queryValueParts[0]);
                return;
            }
            throw new \Exception('CommentFilter have no handler for filter: ' . self::SORT . '=' . $queryValue);
        }

        $builder->orderBy($queryValue);
    }

    /**
     * @return array{array{'key':string, 'possibleValues'?:string}[]}
     */
    public static function getFilterKeyValue(): array
    {
        return [
            ['key' => self::SORT, 'possibleValues' => self::ALLOWED_SORT_BY]
        ];
    }
}
