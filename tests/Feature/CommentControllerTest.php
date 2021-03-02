<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test create comment validation error
     *
     * @return void
     */
    public function testRetrieveComments()
    {
        $response = $this->json('GET', '/api/comments');

        $response->assertStatus(200);
    }

    /**
     * Test create comment validation error
     *
     * @return void
     */
    public function testStoreCommentValidationFailed()
    {
        $response = $this->json('POST', '/api/comments');

        $response->assertStatus(422);
    }

    /**
     * Test create comment success
     *
     * @return void
     */
    public function testStoreCommentSuccess()
    {
        $response = $this->json('POST', '/api/comments', [
            'body' => 'Laravel Rocks',
            'parent_id' => null,
            'username' => 'jdecano',
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'parent_id',
                'username',
                'level',
                'created_at',
                'updated_at'
            ]
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test create comment success with parent
     *
     * @return void
     */
    public function testStoreCommentSuccessWithParent()
    {
        $createdResponse = $this->json('POST', '/api/comments', [
            'body' => 'Laravel Rocks',
            'parent_id' => null,
            'username' => 'jdecano',
        ]);

        $created = json_decode($createdResponse->getContent());

        $response = $this->json('POST', '/api/comments', [
            'body' => 'Laravel Rocks',
            'parent_id' => $created->data->id,
            'username' => 'jdecano',
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'parent_id',
                'username',
                'level',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * Test delete comment 404
     *
     * @return void
     */
    public function testDeleteComment404()
    {
        $response = $this->json('DELETE', '/api/comments/100000');

        $response->assertStatus(404);
    }

    /**
     * Test delete comment success
     *
     * @return void
     */
    public function testDeleteComment()
    {
        $createdResponse = $this->json('POST', '/api/comments', [
            'body' => 'Laravel Rocks',
            'parent_id' => null,
            'username' => 'jdecano',
        ]);

        $created = json_decode($createdResponse->getContent());

        $response = $this->json('DELETE', '/api/comments/' . $created->data->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'parent_id',
                'username',
                'level',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * Test update comment 404
     *
     * @return void
     */
    public function testUpdateComment404()
    {

        $response = $this->json('PUT', '/api/comments/10101010', [
            'body' => 'new content',
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test update comment success
     *
     * @return void
     */
    public function testUpdateComment()
    {
        $createdResponse = $this->json('POST', '/api/comments', [
            'body' => 'Laravel Rocks',
            'parent_id' => null,
            'username' => 'jdecano',
        ]);

        $created = json_decode($createdResponse->getContent());

        $response = $this->json('PUT', '/api/comments/' . $created->data->id, [
            'body' => 'new content',
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'parent_id',
                'username',
                'level',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * Test retrieve comment 404
     *
     * @return void
     */
    public function testShowComment404()
    {

        $response = $this->json('GET', '/api/comments/10101010', [
            'body' => 'new content',
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test retrive comment success
     *
     * @return void
     */
    public function testRetrieveCommentSuccess()
    {
        $createdResponse = $this->json('POST', '/api/comments', [
            'body' => 'Laravel Rocks',
            'parent_id' => null,
            'username' => 'jdecano',
        ]);

        $created = json_decode($createdResponse->getContent());

        $response = $this->json('GET', '/api/comments/' . $created->data->id, [
            'body' => 'new content',
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'body',
                'parent_id',
                'username',
                'level',
                'created_at',
                'updated_at'
            ]
        ]);
    }
}
