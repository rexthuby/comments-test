<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        if (in_array(env('APP_ENV'), ['production', 'testing'])){
//            App in production or testing, next seed only for local
            return;
        }

        $this->generateComment();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    /**
     * First created comment will have many child comment
     * @return void
     */
    private function generateComment(): void
    {
        Comment::factory(10)->create();
        Comment::factory(50)->create();
        Comment::factory(20)->create();
        Comment::factory(30)->create();
        Comment::factory(40)->create();
    }

}
