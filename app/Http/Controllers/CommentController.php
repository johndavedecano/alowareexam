<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Retrieves a comment collection
     */
    public function index(Request $request)
    {
        $query = Comment::select()->with('comments');

        $query = $query->where('parent_id', request('parent_id', null));

        $query = $query->orderBy('created_at', 'desc');

        return CommentResource::collection($query->paginate());
    }

    /**
     * Retrieves a comment from the storage
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);

        return new CommentResource($comment);
    }

    /**
     * Adds a comment to the storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'parent_id' => 'integer|nullable|exists:comments,id',
            'username' => 'required|string|alpha_num',
        ]);

        $params = [
            'body' => $request->get('body'),
            'parent_id' => $request->get('parent_id'),
            'username' => $request->get('username'),
        ];

        if ($params['parent_id']) {
            $parent = Comment::findOrFail($params['parent_id']);
            $params['level'] = $parent->level == Comment::MAX_LEVEL ? Comment::MAX_LEVEL : $parent->level + 1;
            $params['parent_id'] = $parent->level == Comment::MAX_LEVEL ? $parent->parent_id : $parent->id;
        } else {
            $params['level'] = 1;
        }

        $comment = Comment::create($params);

        return new CommentResource($comment);
    }

    /**
     * Updates a comment on the storage
     */
    public function update($id, Request $request)
    {
        $comment = Comment::findOrFail($id);

        $request->validate([
            'body' => 'required|string'
        ]);

        $comment->body = $request->get('body');

        $comment->save();

        return new CommentResource($comment);
    }

    /**
     * Deletes a comment from the storage
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        return new CommentResource($comment);
    }
}
