<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // with tagCount attribute
        $tags = Tag::withCount('post_tags')->orderBy('id', 'desc')->get();

        return view('admin.tags', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        Tag::create([
            'name' => $request->name,
            'slug' => $this->helpers->slugify($request->name),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Etiket başarıyla oluşturuldu.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(TagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update([
            'name' => $request->name,
            'slug' => $this->helpers->slugify($request->name),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Etiket başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->back()->with('success', 'Etiket başarıyla silindi.');
    }

    /**
     * Remove the specified resources from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $tag = Tag::findOrFail($id);
            $tag->delete();
        }

        return response()->json(['success' => "Seçilen etiket(ler) başarıyla silindi."]);
    }

}
