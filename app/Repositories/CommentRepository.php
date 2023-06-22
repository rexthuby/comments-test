<?php

namespace App\Repositories;


use App\Http\Filters\CommentFilter;
use App\Models\Comment as Model;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Query;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentRepository extends CoreRepository
{
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * return default paginated comments based on filter
     * @param string[] $activeFilters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginated(array $activeFilters, int $perPage = 25): LengthAwarePaginator
    {
        $query = $this->getStartCondition()->with('replies');

        $isHaveSort = (bool)request()->query(CommentFilter::SORT);
        if (!$isHaveSort) {
            Model::setDefaultCommentsSort($query);
        }
        $filter = app()->make(CommentFilter::class, ['queryParams' => array_filter($activeFilters)]);
        $query->filter($filter);

        $query->where('parent_id', '=', null);

        $result = $query->paginate($perPage);

        return $result;
    }

    /**
     * @param array{'username': string, "email": string, "url":string|null,
     *     "body":string, "file":string|null, "parent_id":string|null} $commentData
     * @return Eloquent\Builder|Eloquent\Model|Query\Builder
     */
    public function saveNewComment(array $commentData): Eloquent\Model|Eloquent\Builder|Query\Builder
    {
        return $this->getStartCondition()->create($commentData);
    }
}
