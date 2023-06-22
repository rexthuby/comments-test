<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFilterRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class CaptchaController extends Controller
{
    /**
     * get paginated comments
     */
    public function index(CommentFilterRequest $request)
    {
        return response()->json(captcha_img());
    }
}
