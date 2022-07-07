<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    // using trait
    use ApiResourceTrait;
    public function index()
    {

        $posts = PostResource::collection(Posts::get());
        return $this->apiResponse($posts, 'ok', 200);
    }

    public function show($id)
    {
        $post = Posts::find($id);
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'ok', 200);
        }
        return $this->apiResponse(Null, 'Not found', 401);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(Null, $validator->errors(), 400);
        }

        $post = Posts::create($request->all());
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'Post Inserted', 201);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(Null, $validator->errors(), 400);
        }
        $post = Posts::find($id);

        if (!$post) {
            return $this->apiResponse(Null, 'Not found', 401);
        }
        $post->update($request->all());
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'Post Updated', 201);
        }
        return $this->apiResponse(Null, 'Post Not Found', 404);
    }
    public function destroy(Request $request, $id)
    {

        $post = Posts::find($id);
        if (!$post) {
            return $this->apiResponse(Null, 'Not found', 401);
        }
        $post->delete($id);
        if ($post) {
            return $this->apiResponse(Null, 'Post Delete', 200);
        }
    }
}
