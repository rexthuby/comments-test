<?php

namespace App\Services;

use App\FileManagers\FileManagerFabric;
use App\Http\Filters\CommentFilter;
use App\RedisManager\CommentRedisManager;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Query;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    /**
     * @var CommentRepository $commentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param string[] $activeFilters
     * @return LengthAwarePaginator
     */
    public function index(array $activeFilters): LengthAwarePaginator
    {
        /**
         * @var CommentRedisManager $commentRedisManager
         */
        $commentRedisManager = app(CommentRedisManager::class);

        if (request('page')) {
            $commentRedisManager->addRawHashField('page:' . request('page'));
        } else {
            $commentRedisManager->addRawHashField('page:1');
        }

        foreach (CommentFilter::getFilterKeyValue() as $possibleFilter) {
            if (!isset($activeFilters[$possibleFilter['key']])) {
                continue;
            }
            $activeFilterValue = $activeFilters[$possibleFilter['key']];
            if (isset($possibleFilter['possibleValues'])) {
                if (in_array($activeFilterValue, $possibleFilter['possibleValues'])) {
                    $commentRedisManager->addRawHashField($possibleFilter['key'] . ':' . $activeFilterValue);
                }
                continue;
            }
            $commentRedisManager->addRawHashField($possibleFilter['key'] . ':' . $activeFilterValue);
        }

        if (!$commentRedisManager->isExistsHashField($commentRedisManager->getFinalQueryField())) {
            $dbResult = $this->commentRepository->paginated($activeFilters);
            $commentRedisManager->setHashFieldValue($commentRedisManager->getFinalQueryField(), $dbResult);
        }
        return $commentRedisManager->getHashFieldValue($commentRedisManager->getFinalQueryField());
    }

    /**
     * @param array{'username': string, "email": string, "url":string|null,
     *     "body":string, "file":UploadedFile|null, "parent_id":string|null} $validData
     * @return Eloquent\Builder|Eloquent\Model|Query\Builder
     */
    public function store(array $validData): Eloquent\Model|Eloquent\Builder|Query\Builder
    {
        $file = $validData['file'];
        $fileName = null;
        if ($file) {
            /**
             * @var FileManagerFabric $fabric
             */
            $fabric = app(FileManagerFabric::class);
            $fileManager = $fabric->getFabric($file->getMimeType());
            $fileName = $fileManager->save($file);
        }
        $validData['file'] = $fileName;
        return $this->commentRepository->saveNewComment($validData);
    }
}
