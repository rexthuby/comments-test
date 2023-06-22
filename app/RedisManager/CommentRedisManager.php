<?php

namespace App\RedisManager;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CommentRedisManager extends BaseRedisManager
{
    private $rawHashFields = ['comments'];
    private $hashKey = 'comments';

    public function addRawHashField(string $field): void
    {
        array_push($this->rawHashFields, $field);
    }

    public function getFinalQueryField(): string
    {
        return join('_', $this->rawHashFields);
    }

    public function isExistsHashField($field): bool
    {
        return (bool) Redis::hexists($this->hashKey, $field);
    }

    public function getHashFieldValue($field):mixed
    {
        return unserialize(Redis::hget($this->hashKey, $field));
    }

    public function setHashFieldValue(string $field, mixed $value)
    {
        Redis::hset($this->hashKey, $field, serialize($value));
    }

    public function deleteHashKeyFields(): void
    {
        //todo:refactor to flushdb/flush/flushDb
        $keys = Redis::hkeys($this->hashKey);
        if (count($keys) == 0) {
            return;
        }
        foreach ($keys as $key){
            Redis::hdel($this->hashKey, $key);
        }
    }
}
