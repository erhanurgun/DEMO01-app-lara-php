<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount('post_categories')->orderBy('order', 'asc')->get();

        return view('admin.categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'slug' => $this->helpers->slugify($request->name),
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => $this->helpers->slugify($request->name),
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Kategori başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori başarıyla silindi.');
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
            $category = Category::findOrFail($id);
            $category->delete();
        }

        return response()->json(['success' => "Seçilen kategori(ler) başarıyla silindi."]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sortable(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $order => $id) {
            $category = Category::findOrFail($id);
            $category->update(['order' => $order + 1]);
        }

        return response()->json(['success' => "Kategori sıralaması başarıyla kaydedildi."]);
    }
}
