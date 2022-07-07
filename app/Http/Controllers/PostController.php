<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{public function index()
    {
        $posts = Posts::get();
        return view('Post.index', compact('posts'));
    }


    public function create()
    {
        return view('Post.create');
    }


    public function store(StorePostRequest $request)
    {
        try {
            Posts::create($request->all());
            return redirect()->back()->with('success', 'Data saved successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function show(Posts $post)
    {
        //
    }


    public function edit($id)
    {
        $post = Posts::findorFail($id);
        return view('Post.edit', compact('post'));
    }


    public function update(StorePostRequest $request, $id)
    {

        try {
            $post = Posts::findorFail($id);

            $post->update($request->all());

            return redirect()->back()->with('edit', 'Data Updated successfully');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }


    public function destroy($id)
    {
        try {

            Posts::destroy($id);
            return redirect()->back()->with('delete', 'Data has been deleted successfully');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
