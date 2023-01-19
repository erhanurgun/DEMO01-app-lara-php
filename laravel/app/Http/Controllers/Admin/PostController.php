<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Models\PostImage;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    protected $imagePath = 'uploads/posts/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user')->orderBy('id', 'desc')->get();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $req = $request->validated();
        if ($request->hasFile('cover_image')) {
            $imageName = $this->helpers->uploadImage($this->imagePath, $request->file('cover_image'));
            $req['cover_image'] = $imageName;
            $req['thumbnail_image'] = 'thumbnail_' . $imageName;
        }
        $req['user_id'] = auth()->user()->id;
        $req['slug'] = $this->helpers->slugify($req['title']);
        $post = Post::create($req);

        // kategori ekle
        $categories = $request->categories;
        if ($categories) {
            foreach ($categories as $category) {
                PostCategory::create([
                    'post_id' => $post->id,
                    'category_id' => $category,
                ]);
            }
        }

        // etiket ekle
        $tags = $request->tags;
        if ($tags) {
            foreach ($tags as $tag) {
                PostTag::create([
                    'post_id' => $post->id,
                    'tag_id' => $tag,
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Paylaşım başarıyla eklendi.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('user', 'images', 'comments')
            ->withCount('images', 'comments', 'categories', 'tags')->where('id', $id)->first();

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::with('user')->find($id);
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\PostRequest $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        // paylaşımı güncelle
        $post = Post::findOrfail($id);
        $req = $request->validated();
        if ($request->hasFile('cover_image')) {
            $imageName = $this->helpers->uploadImage(
                $this->imagePath, $request->file('cover_image'), $post->cover_image
            );
            $req['cover_image'] = $imageName;
            $req['thumbnail_image'] = 'thumbnail_' . $imageName;
        }
        $req['user_id'] = auth()->user()->id;
        $req['slug'] = $this->helpers->slugify($req['title']);
        $post->update($req);

        // kategori düzenle
        $categories = $request->categories;
        if ($categories) {
            PostCategory::where('post_id', $post->id)->delete();
            foreach ($categories as $category) {
                PostCategory::create([
                    'post_id' => $post->id,
                    'category_id' => $category,
                ]);
            }
        }

        // etiket düzenle
        $tags = $request->tags;
        if ($tags) {
            PostTag::where('post_id', $post->id)->delete();
            foreach ($tags as $tag) {
                PostTag::create([
                    'post_id' => $post->id,
                    'tag_id' => $tag,
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Paylaşım başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post->cover_image) {
            $this->helpers->deleteImage($this->imagePath, $post->cover_image);
        }
        if ($post->thumbnail_image) {
            $this->helpers->deleteImage($this->imagePath, $post->thumbnail_image);
        }
        if ($post->images) {
            foreach ($post->images as $image) {
                $this->helpers->deleteImage($this->imagePath, $image->image);
            }
        }
        $post->delete();

        return redirect()->back()->with('success', 'Paylaşım başarıyla silindi.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(Request $request)
    {
        foreach ($request->ids as $id) {
            $post = Post::find($id);
            if ($post->cover_image) {
                $this->helpers->deleteImage($this->imagePath, $post->cover_image);
            }
            if ($post->thumbnail_image) {
                $this->helpers->deleteImage($this->imagePath, $post->thumbnail_image);
            }
            if ($post->images) {
                foreach ($post->images as $image) {
                    $this->helpers->deleteImage($this->imagePath, $image->image);
                }
            }
            $post->delete();
        }

        return response()->json(['success' => 'Paylaşım(lar) başarıyla silindi.']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Evaluation $evaluation
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $post = Post::find($request->id);
        $post->status = $request->status;
        $post->save();

        $message = "\"{$post->title}\" adlı paylaşımın durumunu";
        $status = $request->status === 'active' ? 'aktif' : 'pasif';
        $message .= " {$status} olarak güncellediniz!";
        $this->helpers->log($message, 'success');

        return response()->json([
            'success' => "Paylaşımın durumunu {$status} olarak güncellediniz!",
            'status' => $request->status
        ]);
    }
}
