<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPost = Post::published()
            ->with([
                'user',
                'category',
            ])
            ->withCount('views')
            ->latest('published_at')
            ->first();
        // dd($featuredPost);
        $posts = Post::published()
            ->with([
                'user',
                'category',
                'tags',
            ])
            ->when(
                $featuredPost,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $featuredPost->id
                )
            )
            ->withCount('views')
            ->latest('published_at')
            ->paginate(10);

        $categories = Category::query()
            ->withCount([
                'posts' => function ($query) {
                    $query
                        ->where('status', 'published')
                        ->whereNotNull('published_at');
                },
            ])
            ->orderByDesc('posts_count')
            ->take(6)
            ->get();

        // جلب المقالات الرائجة بناءً على التفاعلات والتعليقات فقط خلال آخر 7 أيام
        $trendingStories = Post::published()
            ->with(['user', 'category'])
            ->withCount('views') // جلب عدد المشاهدات
            ->where('created_at', '>=', Carbon::now()->subDays(60))
            ->select('posts.*')

    // حساب نقاط التفاعلات
            ->selectSub(function ($query) {
                $query->from('reactions')
                    ->whereColumn('reactions.post_id', 'posts.id')
                    ->selectRaw('count(*)');
            }, 'reactions_count')

    // حساب نقاط التعليقات
            ->selectSub(function ($query) {
                $query->from('comments')
                    ->whereColumn('comments.post_id', 'posts.id')
                    ->selectRaw('count(*)');
            }, 'comments_count')

    // الترتيب بمعادلة وزن النقاط: (المشاهدات * 1) + (التفاعلات * 3) + (التعليقات * 5)
            ->orderByRaw('
        (COALESCE((SELECT count(*) FROM post_views WHERE post_views.post_id = posts.id), 0) * 1) +
        (COALESCE((SELECT count(*) FROM reactions WHERE reactions.post_id = posts.id), 0) * 3) +
        (COALESCE((SELECT count(*) FROM comments WHERE comments.post_id = posts.id), 0) * 5) DESC
    ')
            ->take(3)
            ->get();

        //dd($trendingStories->count());

        return view('pages.home', compact(
            'featuredPost',
            'posts',
            'categories',
            'trendingStories'
        ));
    }
}
