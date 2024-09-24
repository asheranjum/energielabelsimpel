<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiHelper;
use DB;
use App\Product;
use App\Models\ProductCategory;
use App\ProductSubCategory;
use App\Slider;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{
    //

    public function getCategories()
    {

        $cats = ProductCategory::where('status','PUBLISHED')->with('getSubCategory')->orderBy('created_at', 'DESC')->get();
        $result = ApiHelper::success('All Categories Loaded', $cats);
		return response()->json($result, 200);

    }

//     public function getCategoryProduct($slug)
// 	{
//         // $slugtoString = str_replace('-', ' ', $slug);
        
//         // dd($slugtoString);
		
// // 		$products = ProductCategory::published()->with('category_products')->where('slug', $slug)->first();
		
// // 		$numberOfProducts = count($products->category_products);
// // 		$products->total_products = $numberOfProducts;
// //         return($products);
// // 		$result = ApiHelper::success('product-details', $products);
// // 		return response()->json($result, 200);


//     $productsCategory = ProductCategory::published()
//         ->where('slug', $slug)
//         ->first();

//     if (!$productsCategory) {
//         return response()->json(['message' => 'No products found'], 404);
//     }

//     $perPage = 10;

//     $categoryProducts = Product::where('category_id', $productsCategory->id)
//         ->with('category')
//         ->with('subcategory')
//         ->paginate($perPage);

//     $paginationData = [
//         'total' => $categoryProducts->total(),
//         'per_page' => $categoryProducts->perPage(),
//         'current_page' => $categoryProducts->currentPage(),
//         'last_page' => $categoryProducts->lastPage(),
//         'next_page_url' => $categoryProducts->nextPageUrl(),
//         'prev_page_url' => $categoryProducts->previousPageUrl(),
//         'data' => $categoryProducts->items(),
//     ];

//   $pageUrls = [];

//     for ($page = 1; $page <= $paginationData['last_page']; $page++) {
//         $pageUrls[$page] = $categoryProducts->url($page);
//     }

//     $paginationData['links'] = $pageUrls;
    
//     $productsCategory->pagination = $paginationData;

//     $result = ApiHelper::success('product-details', $productsCategory);

//     return response()->json($result, 200);
    
// 	}



        // public function getCategoryProduct($slug)
        // {
        //     $productsCategory = ProductCategory::published()
        //         ->where('slug', $slug)
        //         ->first();
        
        //     if (!$productsCategory) {
        //         return response()->json(['message' => 'No products found'], 404);
        //     }
        
        //     $perPage = 12;
        
        //     $categoryProducts = Product::where('category_id', $productsCategory->id)->published()
        //         ->with('category')
        //         ->with('subcategory')
        //         ->paginate($perPage);
        
        //     $paginationData = [
        //         'total' => $categoryProducts->total(),
        //         'per_page' => $categoryProducts->perPage(),
        //         'current_page' => $categoryProducts->currentPage(),
        //         'last_page' => $categoryProducts->lastPage(),
        //         'data' => $categoryProducts->items(),
        //     ];
        
        //     $pageUrls = [];
        
        //     // Add "Previous" link
        //     if ($categoryProducts->currentPage() > 1) {
        //         $prevPageUrl = $categoryProducts->previousPageUrl();
        //         $pageUrls[] = [
        //             'url' => $prevPageUrl,
        //             'label' => '&laquo; Previous',
        //             'active' => false,
        //         ];
        //     }
        
        //     // Add individual page links
        //     for ($page = 1; $page <= $paginationData['last_page']; $page++) {
        //         $pageUrls[] = [
        //             'url' => $categoryProducts->url($page),
        //             'label' => $page,
        //             'active' => ($page === $categoryProducts->currentPage()),
        //         ];
        //     }
        
        //     // Add "Next" link
        //     if ($categoryProducts->hasMorePages()) {
        //         $nextPageUrl = $categoryProducts->nextPageUrl();
        //         $pageUrls[] = [
        //             'url' => $nextPageUrl,
        //             'label' => 'Next &raquo;',
        //             'active' => false,
        //         ];
        //     }
        
        //     $paginationData['links'] = $pageUrls;
        
        //     $productsCategory->pagination = $paginationData;
        
        //     $result = ApiHelper::success('product-details', $productsCategory);
        
        //     return response()->json($result, 200);
        // }


        public function getCategoryProduct($slug, Request $request)
        {
            $productsCategory = ProductCategory::published()
                ->where('slug', $slug)
                ->first();
        
            if (!$productsCategory) {
                return response()->json(['message' => 'No products found'], 404);
            }
        
            $perPage = $request->input('count', 12); // Number of products per page
        
            $categoryProducts = Product::where('category_id', $productsCategory->id)
                ->published()
                ->with('category')
                ->with('subcategory');
        
            // Sorting logic
            $orderBy = $request->input('orderby', 'created_at');
            switch ($orderBy) {
                // case 'popularity':
                //     $categoryProducts->orderBy('popularity_column');
                //     break;
                // case 'rating':
                //     $categoryProducts->orderBy('average_rating_column');
                //     break;
                case 'newness':
                    $categoryProducts->orderByDesc('created_at');
                    break;
                case 'low-to-high':
                    $categoryProducts->orderBy('regular_price');
                    break;
                case 'high-to-low':
                    $categoryProducts->orderByDesc('regular_price');
                    break;
                default:
                    // Default sorting
                    $categoryProducts->orderBy('created_at');
                    break;
            }
        
            $categoryProducts = $categoryProducts->paginate($perPage);
        

            $paginationData = [
                'total' => $categoryProducts->total(),
                'per_page' => $categoryProducts->perPage(),
                'current_page' => $categoryProducts->currentPage(),
                'last_page' => $categoryProducts->lastPage(),
                'next_page_url' => $categoryProducts->nextPageUrl(),
                'prev_page_url' => $categoryProducts->previousPageUrl(),
                'data' => $categoryProducts->items(),
            ];
        
            $pageUrls = [];
        
            // Add "Previous" link
            if ($categoryProducts->currentPage() > 1) {
                $prevPageUrl = $categoryProducts->previousPageUrl();
                $pageUrls[] = [
                    'url' => $prevPageUrl,
                    'label' => '&laquo; Previous',
                    'active' => false,
                ];
            }
        
            // Add individual page links
            for ($page = 1; $page <= $paginationData['last_page']; $page++) {
                $pageUrls[] = [
                    'url' => $categoryProducts->url($page),
                    'label' => $page,
                    'active' => ($page === $categoryProducts->currentPage()),
                ];
            }
        
            // Add "Next" link
            if ($categoryProducts->hasMorePages()) {
                $nextPageUrl = $categoryProducts->nextPageUrl();
                $pageUrls[] = [
                    'url' => $nextPageUrl,
                    'label' => 'Next &raquo;',
                    'active' => false,
                ];
            }
        
            $paginationData['links'] = $pageUrls;
        
            $productsCategory->pagination = $paginationData;
        
            $result = ApiHelper::success('product-details', $productsCategory);
        
            return response()->json($result, 200);
        }


    public function getSubCategoryProduct($slug, Request $request)
	{
        // $slugtoString = str_replace('-', ' ', $slug);
        
        // dd($slugtoString);
		
// 		$products = ProductSubCategory::published()->with('category_sub_products')->where('slug', $slug)->first();

// 		$result = ApiHelper::success('product-details', $products);
// 		return response()->json($result, 200);


            $productsCategory = ProductSubCategory::published()
                ->where('slug', $slug)
                ->first();
        
            if (!$productsCategory) {
                return response()->json(['message' => 'No products found'], 404);
            }
        
            $perPage = $request->input('count', 12); // Number of products per page
        
            $categoryProducts = Product::where('sub_category_id', $productsCategory->id)
                ->published()
                ->with('category')
                ->with('subcategory');
        
            // Sorting logic
            $orderBy = $request->input('orderby', 'created_at');
            switch ($orderBy) {
                // case 'popularity':
                //     $categoryProducts->orderBy('popularity_column');
                //     break;
                // case 'rating':
                //     $categoryProducts->orderBy('average_rating_column');
                //     break;
                case 'newness':
                    $categoryProducts->orderByDesc('created_at');
                    break;
                case 'low-to-high':
                    $categoryProducts->orderBy('regular_price');
                    break;
                case 'high-to-low':
                    $categoryProducts->orderByDesc('regular_price');
                    break;
                default:
                    // Default sorting
                    $categoryProducts->orderBy('created_at');
                    break;
            }
        
            $categoryProducts = $categoryProducts->paginate($perPage);
        

            $paginationData = [
                'total' => $categoryProducts->total(),
                'per_page' => $categoryProducts->perPage(),
                'current_page' => $categoryProducts->currentPage(),
                'last_page' => $categoryProducts->lastPage(),
                'next_page_url' => $categoryProducts->nextPageUrl(),
                'prev_page_url' => $categoryProducts->previousPageUrl(),
                'data' => $categoryProducts->items(),
            ];
        
            $pageUrls = [];
        
            // Add "Previous" link
            if ($categoryProducts->currentPage() > 1) {
                $prevPageUrl = $categoryProducts->previousPageUrl();
                $pageUrls[] = [
                    'url' => $prevPageUrl,
                    'label' => '&laquo; Previous',
                    'active' => false,
                ];
            }
        
            // Add individual page links
            for ($page = 1; $page <= $paginationData['last_page']; $page++) {
                $pageUrls[] = [
                    'url' => $categoryProducts->url($page),
                    'label' => $page,
                    'active' => ($page === $categoryProducts->currentPage()),
                ];
            }
        
            // Add "Next" link
            if ($categoryProducts->hasMorePages()) {
                $nextPageUrl = $categoryProducts->nextPageUrl();
                $pageUrls[] = [
                    'url' => $nextPageUrl,
                    'label' => 'Next &raquo;',
                    'active' => false,
                ];
            }
        
            $paginationData['links'] = $pageUrls;
        
            $productsCategory->pagination = $paginationData;
        
            $result = ApiHelper::success('product-details', $productsCategory);
        
            return response()->json($result, 200);
	}
	

    
    public function getProductsWithCategories()
	{
		
		$products = ProductCategory::published()->with('category_products')->get();

		$result = ApiHelper::success('product-details', $products);
		return response()->json($result, 200);
	}
	


    public function slider(Request $request)
	{
		$lang = $request->query('lang', 'en'); // Default to 'en' if no language is specified
	
		$slider = Slider::with(['translations' => function ($query) use ($lang) {
			$query->where('locale', $lang);
		}])->get();
	
		$result = ApiHelper::success('playlist', $slider);
		return response()->json($result, 200);
	}
	
	

}
