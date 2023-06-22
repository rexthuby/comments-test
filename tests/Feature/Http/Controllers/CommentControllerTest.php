<?php

namespace Http\Controllers;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private $baseRoute = '/api/v1/comment';

    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        Comment::factory(1)->create();

        $this->seed();

    }

    public function test_index_status_200(): void
    {
        $response = $this->getJson($this->baseRoute);

        $response->assertStatus(200);
    }

    public function test_index_have_correct_paginate_data(): void
    {
        Comment::factory(1)->create();
        $response = $this->getJson($this->baseRoute.'?sort=username');
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->hasAll(['meta', 'links', 'data.0'])
        );
    }

    public function test_store_with_all_correct_fields_status_201(): void
    {
        Storage::fake('public');

        $commentData = $this->getStoreStaticData();
        $response = $this->postJson($this->baseRoute, $commentData);
        $response->assertStatus(201);
    }

    public function test_store_with_wrong_body_field_status_422(): void
    {
        Storage::fake('public');

        $commentData = $this->getStoreStaticData();
        $commentData['body'] = '<div>wrong body type</div>';
        $response = $this->postJson($this->baseRoute, $commentData);
        $response->assertStatus(422);
    }

    public function test_store_with_wrong_file_size_field_status_422(): void
    {
        Storage::fake('public');

        $commentData = $this->getStoreStaticData();
        $commentData['file'] = UploadedFile::fake()->create('test.txt', 101, 'text/plain');
        $response = $this->postJson($this->baseRoute, $commentData);
        $response->assertStatus(422);
    }

    public function test_store_with_image_field_status_201(): void
    {
        Storage::fake('public');

        $commentData = $this->getStoreStaticData();
        $commentData['file'] = UploadedFile::fake()->image('image.png', 1920, 1080);
        $response = $this->postJson($this->baseRoute, $commentData);
        $response->assertStatus(201);
    }

    private function getStoreStaticData(): array
    {
        $username = 'Danil';
        $email = "danil@gmail.com";
        $url = "https://www.instagram.com/";
        $body = "This is <strong>strong</strong> body!";
        $file = UploadedFile::fake()->create('test.txt', 50, 'text/plain');
        $parent = null;
        return [
            "username" => $username,
            "email" => $email,
            "url" => $url,
            "body" => $body,
            "file" => $file,
            "parent_id" => $parent
        ];
    }

}
