<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Attribute;
use App\AttributeType;
use App\TagProductPivot;
use App\ProductCustomization;
use App\Product;
use App\Review;
use App\Tag;
use App\Models\ProductCategory;
use App\Helpers\ApiHelper;
use Illuminate\Support\Str;
use DB;
use Illuminate\Pagination\Paginator;

class ProductsController extends Controller
{

	public function index()
	{

		$products = Product::published()->with('category')->with('subcategory')->orderBy('id', 'DESC')->take(12)->get();

		$result = ApiHelper::success('All Products', $products);
		return response()->json($result, 200);
	}


	public function getProductDetail($slug)
	{

		// Extract the product title and ID from the slug
		$parts = explode('-', $slug);

		// The last element in the array will be the product ID
		$productId = end($parts);

		// The product title is the remaining elements in the array
		$productTitle = implode(' ', array_slice($parts, 0, -1));

		$products = Product::published()->with('category')->with('subcategory')->where('id', $productId)->first();
		
		// $ProductCustomization = ProductCustomization::with('module_3d')->with('module_attributes')->with('module_attributes_values')->where('product_id', $productId)->first();
		
		
		// if ($ProductCustomization) {
        //     $moduleAttributesValues = $ProductCustomization->module_attributes_values;
        
        //     // Iterate through module_attributes_values and add attribute_name
        //     foreach ($moduleAttributesValues as $value) {
        //         $attributeId = $value->attribute_id;
        //         $attribute = $ProductCustomization->module_attributes->where('id', $attributeId)->first();
        
        //         if ($attribute) {
        //             $value->attribute_name = $attribute->attribute_name;
        //         }
        //     }
        
        //     // Now $moduleAttributesValues will have an additional attribute_name field
        // }
		
		//  if ($products && $products->is_3d == 1) {
        //     $products->product_customization = $ProductCustomization;
        // }
    
// 		return($ProductCustomization);


		$result = ApiHelper::success('product-details', $products);
		
		return response()->json($result, 200);
	
	}



	public function getProductAttributes($category_id)
	{



		$category = ProductCategory::findOrFail($category_id);

		$attributePivots = $category->attributePivots;

		$attributeTypeIds = $attributePivots->pluck('attribute_type_id')->unique();

		$attributeTypes = AttributeType::with('attributes')->whereIn('id', $attributeTypeIds)->get();

		$attributes = $attributeTypes->flatMap(function ($type) {
			return $type->attributes;
		});

		$data = [
			'attributes' => $attributes,
			'attribute_types' => $attributeTypes,
		];


		$result = ApiHelper::success('product-details', $data);
		return response()->json($result, 200);
	}



	public function searchByCategory(Request $request)
	{

		// // dd($category , $name);

		// $searchData = Product::where('name', 'LIKE', '%' .  $request->input('query') . '%')->get();
		// // dd(count($result));


		// if (count($searchData)) {
		// 	$result = ApiHelper::success(count($searchData) . ' Product Found', $searchData);
		// 	return response()->json($result, 200);
		// } else {
		// 	$result = ApiHelper::successMessage('No Data not found');
		// 	return response()->json($result, 200);
		// }


		$query = $request->input('query');
		$category = $request->input('category');
		$perPage = $request->input('perPage', 12); // Default value is 10 if not provided
		$sortBy = $request->input('sortBy', 'default'); // Default sorting is set to 'default'
	
		$products = Product::query();
	
		$products->with('category')->with('subcategory');
	
		if ($query) {
			$products->where('name', 'like', '%' . $query . '%')
				->orWhere('short_desc', 'like', '%' . $query . '%')
				->orWhere('long_desc', 'like', '%' . $query .'%');
		}
	
		if ($category) {
			$products->where('category_id', $category);
		}
	

		if ($sortBy === 'priceLowToHigh') {
			$products->orderBy('regular_price', 'asc');
		} elseif ($sortBy === 'priceHighToLow') {
			$products->orderBy('regular_price', 'desc');
		} elseif ($sortBy === 'newest') {
			$products->orderBy('created_at', 'desc');
		} elseif ($sortBy === 'popular') {
			// $products->withCount('orders')->orderBy('orders_count', 'desc');


			// $products->orderBy(
			// 	DB::raw('(SELECT COUNT(*) FROM orders WHERE JSON_CONTAINS(product, \'{"id":'.$products->getQuery()->from.'.id}\'))'),
			// 	'desc'
			// );
		}

		
		$searchData = $products->paginate($perPage);


		if (count($searchData)) {
			$result = ApiHelper::success(count($searchData) . ' Products Found', $searchData);
			return response()->json($result, 200);
		} else {
			$result = ApiHelper::successMessage('No Result Found');
			return response()->json($result, 200);
		}
		
	}

	public function TagsProducts()
	{

		$tagsWithProducts = Tag::with('products')->where('status','PUBLISHED')->get();


		// $getPorducts = TagProductPivot::with('getTags')->with('getProducts')->get();

		// $ttt =  collect( $getPorducts )->unique();

		$result = ApiHelper::success('Success', $tagsWithProducts);
		return response()->json($result, 200);
	}
	
	public function HomeReviews()
	{

		$reviews = Review::where('status','PUBLISHED')->get();


		

		$result = ApiHelper::success('Success', $reviews);
		return response()->json($result, 200);
	}



}
