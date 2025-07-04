<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prompt; // Eşleşen model varsa
use App\Models\Category;

class PromptController extends Controller
{
    public function home()
    {
        $prompts = Prompt::latest()->take(10)->get();

        // Satıcılar: Son 4 kullanıcı (örnek amaçlı)
        $sellers = \App\Models\User::latest()->take(4)->get()->map(function($user) {
            return [
                'image' => $user->avatar ?? 'assets/images/sellers/default.png',
                'name'  => $user->name,
                'url'   => '/nft-detail', // Kullanıcıya özel url yapılabilir
                'spend' => '$1,954' // Gerçek veri için ek sütun gerekebilir
            ];
        });

        // Sanatçılar: Son 2 kullanıcı (örnek amaçlı)
        $artists = \App\Models\User::latest()->take(2)->get()->map(function($user) {
            return [
                'cover' => $user->cover ?? 'assets/images/artists/default-cover.png',
                'avatar' => $user->avatar ?? 'assets/images/artists/default-avatar.png',
                'name' => $user->name,
                'url' => '/' // Kullanıcıya özel url yapılabilir
            ];
        });

        // Bloglar: Son 3 blog kaydı
        $blogs = \App\Models\Blog::latest()->take(3)->get()->map(function($blog) {
            return [
                'image' => $blog->image ?? 'assets/images/blog/default.png',
                'title' => $blog->title,
                'tag' => $blog->tag,
                'writer' => $blog->writer,
                'date' => $blog->date ? \Carbon\Carbon::parse($blog->date)->format('M d Y') : '',
                'url' => $blog->url ?? '/blog',
                'detail_url' => $blog->detail_url ?? '/blog-details',
            ];
        });
        $prompts = Prompt::latest()->get(); // ya da paginate()
        $categories = Category::with('prompts')->get();
    

        return view('home', compact('prompts', 'categories','sellers', 'artists', 'blogs'));
    }
}
