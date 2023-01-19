<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use App\Models\PostImage;
use App\Models\Post;

class PostImageController extends Controller
{
    protected $imagePath = 'uploads/posts/images/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $post = Post::findOrFail($id);
        $images = $post->images;

        return view('admin.posts.images', compact('images', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request, $id)
    {
        foreach ($request->images as $image) {
            $imageName = $this->helpers->uploadImage($this->imagePath, $image);
            PostImage::create([
                'post_id' => $id,
                'image' => $imageName,
                'thumbnail' => 'thumbnail_' . $imageName
            ]);
        }

        return redirect()->back()->with('success', 'Seçilen resim(ler) başarıyla yüklendi.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(Request $request)
    {
         $ids = $request->ids;
        foreach ($ids as $id) {
            $image = PostImage::findOrFail($id);
            $this->helpers->deleteImage($this->imagePath, $image->image);
            $image->delete();
        }

        return response()->json(['success' => "Seçilen resim(ler) başarıyla silindi."]);
    }
}
