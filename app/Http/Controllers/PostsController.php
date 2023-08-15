<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('blog.index', [
            'posts' => Post::orderBy('updated_at', 'desc')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request)
    {
        $request->validated();

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'min_to_read' => $request->min_to_read,
            'is_published' => $request->is_published === 'on',
            'image_path' => $this->storeImage($request)
        ]);

        $post->meta()->create([
            'post_id' => $post->id,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'meta_robots' => $request->meta_robots
        ]);

        return redirect(route('blog.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('blog.show', [
            'post' => Post::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('blog.edit', [
            'post' => Post::where('id', $id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, string $id)
    {
        $request->validated();

        Post::where('id', $id)->update($request->except([
            '_token', '_method']
        ));        

        return redirect(route('blog.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);
        return redirect(route('blog.index'))->with('message', 'Post has been deleted.');
    }

    private function storeImage($request) 
    {
        $newImageName = uniqid() . '-' . $request->title . '.' . 
        $request->image->extension();
        
        return $request->image->move(public_path('images'), $newImageName);
    }
}
