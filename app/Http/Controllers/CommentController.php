<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFilterRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    /**
     * @var CommentService $service
     */
    private $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    /**
     * get paginated comments
     */
    public function index(CommentFilterRequest $request): AnonymousResourceCollection
    {
        $activeFilters = $request->validated();
        $comments = $this->service->index($activeFilters);
        return CommentResource::collection($comments);
    }

    /**
     * @param CommentStoreRequest $request
     * @return CommentResource
     */
    public function store(CommentStoreRequest $request): CommentResource
    {
        $validated = $request->validated();
        $this->setNull($validated, ['file', 'parent_id']);
        $result = $this->service->store($validated);
        return new CommentResource($result);
    }

    private function setNull(&$validated, $nullableKey)
    {
        foreach ($nullableKey as $key) {
            if (!isset($validated[$key])) {
                $validated[$key] = null;
            }
        }
    }
}
