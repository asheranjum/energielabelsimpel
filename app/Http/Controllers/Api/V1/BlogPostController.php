<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use TCG\Voyager\Models\Post;
use TCG\Voyager\Models\Category;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    // public function index(Request $request)
    // {
    //     $locale = $request->query('lang', 'en'); // Default to 'en' if no language is specified
    //     app()->setLocale($locale);

    //     $posts = Post::where('status', 'PUBLISHED')
    //                  ->with(['translations' => function ($query) use ($locale) {
    //                      $query->where('locale', $locale);
    //                  }, 'category'])
    //                  ->get();

    //     $result = ApiHelper::success('posts', $posts);
    //     return response()->json($result, 200);
    // }


    public function index(Request $request)
    {
        $locale = $request->query('lang', 'en'); // Default to 'en' if no language is specified
        app()->setLocale($locale);

        $perPage = $request->input('count', 3); // Number of posts per page, default to 10

        $posts = Post::where('status', 'PUBLISHED')
            ->with(['translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }, 'category'])
            ->paginate($perPage);

        $result = ApiHelper::success('posts', $posts);
        return response()->json($result, 200);
    }


    public function getCategory(Request $request)
    {

        // dd($request->all());
        $locale = $request->query('lang', 'en'); // Default to 'en' if no language is specified
        app()->setLocale($locale);

        // $perPage = $request->input('count', 10); // Number of posts per page, default to 10

        $cat = Category::where('status', 'PUBLISHED')
            ->with(['translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->get();

        $result = ApiHelper::success('categories', $cat);
        return response()->json($result, 200);
    }



    public function getCategoryBlogs(Request $request, $slug)  // Include $slug to capture the category slug from the route
    {
        // Set the requested locale or default to 'en'
        $locale = $request->query('lang', 'en');
        app()->setLocale($locale);
    
        // Set the number of posts per page, default to 10
        $perPage = $request->input('count', 10);
    
        // Retrieve posts that are published and belong to the specified category slug
        $posts = Post::where('status', 'PUBLISHED')
                     ->whereHas('category', function($query) use ($slug) {
                         $query->where('slug', $slug);  // Filter posts by category slug
                     })
                     ->with(['translations' => function ($query) use ($locale) {
                         $query->where('locale', $locale);
                     }, 'category'])
                     ->paginate($perPage);
    
        // Prepare and return the API response
        $result = ApiHelper::success('posts', $posts);
        return response()->json($result, 200);
    }
    


    public function show($slug, Request $request)
    {
        $locale = $request->query('lang', 'en'); // Default to 'en' if no language is specified
        app()->setLocale($locale);

        $post = Post::where('slug', $slug)
            ->where('status', 'PUBLISHED')
            ->with(['translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }, 'category'])
            ->firstOrFail();

        $result = ApiHelper::success('single-post', $post);
        return response()->json($result, 200);
    }


    public function getFeaturedPosts(Request $request)
    {
        $locale = $request->query('lang', 'en'); // Default to 'en' if no language is specified
        app()->setLocale($locale);

        $featuredPosts = Post::where('status', 'PUBLISHED')
            ->where('featured', 1)
            ->with(['translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }, 'category'])
            ->take(3)
            ->get();

        $result = ApiHelper::success('featured-posts', $featuredPosts);
        return response()->json($result, 200);
    }
}
