<?php

namespace App\Observers;

use App\Models\Comment;
use App\RedisManager\CommentRedisManager;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        $commentRedisManager = app(CommentRedisManager::class);
        $commentRedisManager->deleteHashKeyFields();
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        $commentRedisManager = app(CommentRedisManager::class);
        $commentRedisManager->deleteHashKeyFields();
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        $commentRedisManager = app(CommentRedisManager::class);
        $commentRedisManager->deleteHashKeyFields();
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        $commentRedisManager = app(CommentRedisManager::class);
        $commentRedisManager->deleteHashKeyFields();
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        $commentRedisManager = app(CommentRedisManager::class);
        $commentRedisManager->deleteHashKeyFields();
    }
}
