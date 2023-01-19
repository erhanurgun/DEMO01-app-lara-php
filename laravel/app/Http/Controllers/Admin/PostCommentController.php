<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCommentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostComment;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postComments = PostComment::with('post', 'user')->get();

        return view('admin.posts.comments', compact('postComments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCommentRequest $request)
    {
        PostComment::create($request->all());

        return redirect()->back()->with('success', 'Yorum başarıyla oluşturuldu.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postComment = PostComment::find($id);
        $postComment->delete();

        return redirect()->back()->with('success', 'Yorum başarıyla silindi.');
    }

    // destroyBulk
    public function destroyBulk(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $postComment = PostComment::find($id);
            $postComment->delete();
        }

        return response()->json(['success' => "Seçilen yorum(lar) başarıyla silindi."]);
    }

    public function status(Request $request)
    {
        $evaluation = PostComment::find($request->id);
        $evaluation->status = $request->status;
        $evaluation->save();

        if ($request->status === 'active') {
            return response()->json([
                'success' => "Yorum başarıyla yayınlandı.",
                'status' => 'active'
            ]);
        } else {
            return response()->json([
                'success' => "Yorum yayından kaldırıldı.",
                'status' => 'passive'
            ]);
        }
    }
}
