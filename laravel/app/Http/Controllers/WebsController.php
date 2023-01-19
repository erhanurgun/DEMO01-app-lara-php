<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\PostComment;
use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Tag;

class WebsController extends Controller
{
    protected $user, $menu, $socials, $popularPosts, $tags, $categories, $data = [];

    public function __construct()
    {
        $this->user = User::findOrfail(1)->with('details')->first();
        $this->menus = Menu::where('status', 'active')->orderBy('order')->get();
        $this->socials = json_decode($this->user->details->socials);
        $this->popularPosts = Post::where('status', 'active')->orderBy('view_count', 'desc')->take(3)->get();
        $this->tags = Tag::where('status', 'active')->orderBy('id', 'desc')->get();
        $this->categories = Category::withCount('post_categories')->where('status', 'active')->orderBy('order')->get();
        $this->data = [
            'user' => $this->user,
            'menus' => $this->menus,
            'socials' => $this->socials,
            'popularPosts' => $this->popularPosts,
            'tags' => $this->tags,
            'categories' => $this->categories,
        ];
    }

    public function index()
    {
        $galleries = Gallery::orderBy('id', 'desc')->take(9)->get();
        $lastPosts = Post::where('status', 'active')->orderBy('id', 'desc')->take(3)->get();
        //$galeries = Galery::where('status', 'active')->orderBy('id', 'desc')->take(3)->get();

        return view('webs.index', compact('galleries', 'lastPosts'), $this->data);
    }

    public function about()
    {
        return view('webs.about', $this->data);
    }

    public function contact()
    {
        return view('webs.contact', $this->data);
    }

    public function contactStore(ContactRequest $request)
    {
        try {
            $data = Contact::create($request->validated());
            $mailForContact = Mail::to($data->email)->send(new ContactMail);
            $mailForAdmin = Mail::to($this->user->email)->send(new ContactMail);

            if ($data && $mailForContact && $mailForAdmin) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Mesajınızı aldım. Size en kısa sürede geri dönüş yapacağım!'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mesajınız gönderilemedi. Lütfen daha sonra tekrar deneyiniz!'
            ], 500);
        }
    }

    public function gallery()
    {
        $galleries = Gallery::orderBy('id', 'desc')->get();
        return view('webs.gallery', compact('galleries'), $this->data);
    }

    public function posts()
    {
        $posts = Post::where('status', 'active')->orderBy('id', 'desc')->paginate(3);
        return view('webs.posts.index', compact('posts'), $this->data);
    }

    public function post($slug)
    {
        $post = Post::with('images')->where('slug', $slug)->first() ?? abort(404);
        $previous = Post::where('id', '<', $post->id)
            ->where('status', 'active')->orderBy('id', 'desc')->first();
        $next = Post::where('id', '>', $post->id)
            ->where('status', 'active')->orderBy('id', 'asc')->first();

        return view('webs.posts.show', compact('post', 'previous', 'next'), $this->data);
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->first() ?? abort(404);
        $posts = $tag->posts()->paginate(3);

        return view('webs.posts.index', compact('posts'), $this->data);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first() ?? abort(404);
        $posts = $category->posts()->paginate(3);

        return view('webs.posts.index', compact('posts'), $this->data);
    }

    public function search(Request $request)
    {
        $search = $request->q;
        $posts = Post::where('title', 'like', "%$search%")
            ->orWhere('body', 'like', "%$search%")->paginate(3);

        return view('webs.posts.index', compact('posts'), $this->data);
    }

    public function commentStore(Request $request)
    {
        try {
            $data = new PostComment();
            $data->post_id = $request->post_id;
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->email = $request->email;
            $data->comment = $request->comment;
            $data->save();

            if ($data) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Yorumunuz başarıyla eklendi. Onaylandıktan sonra yayınlanacaktır.'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Yorumunuz eklenemedi. Lütfen daha sonra tekrar deneyiniz!'
            ], 500);
        }
    }

    // post hit
    public function hit($id)
    {
        $post = Post::find($id);
        $post->view_count = $post->view_count + 1;
        $post->save();

        return response()->json([
            'status' => 'hited'
        ], 200);
    }

    // post like
    public function like($id)
    {
        $post = Post::find($id);
        $post->likes_count = $post->likes_count + 1;
        $post->save();

        return response()->json([
            'status' => 'liked'
        ], 200);
    }
}
