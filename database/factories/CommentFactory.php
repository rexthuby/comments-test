<?php

namespace Database\Factories;

use App\Models\Comment;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isHaveParent = random_int(1, 10) <= 7; //70% - chance that a comment will have a parent comment
        $parentId = null;

        $username = fake()->userName();
        $email = fake()->email();
        $url = fake()->url();
        $body = fake()->text();
        $depth = 0;

        if ($isHaveParent) {
            $parentId = $this->getParentId();
            $depth = Comment::find($parentId, 'depth')->depth + 1;
        }

        return [
            'username' => $username,
            'email' => $email,
            'url' => $url,
            'body' => $body,
            'parent_id' => $parentId,
            'file' => null,
            'depth' => $depth
        ];
    }

    private function isModelHaveRecords(): bool
    {
        return (bool) Comment::count();
    }

    /**
     * Check is model have records. If model don't have it, create 1. Else, return parent id
     * @return int
     */
    private function getParentId(): int
    {
        if (!$this->isModelHaveRecords()) {
            return Comment::create([
                'username' => fake()->userName(),
                'email' => fake()->email(),
                'url' => fake()->url(),
                'body' => fake()->text(),
                'parent_id' => null,
                'file' => null,
            ])->id;
        }
        return FactoryHelper::getRandomModelId(Comment::class);
    }
}
