<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductCustomization;
use DB;

class ProductDuplicationController extends Controller
{
    //



    public function duplicate(Request $request, Product $product)
    {
        $newProduct = $product->replicate();
        $newProduct->name = 'Copy of ' . $product->name; // Modify any attributes as needed
        $newProduct->images = null;
        // $newProduct->created_at = \Carbon\Carbon::now()->toDateTimeString();
        // $newProduct->updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $newProduct->save();

        // You may also need to duplicate any related data, such as images or tags, depending on your application's structure.

        return redirect()->route('voyager.products.index')->with('success', 'Product duplicated successfully.');
    }
    
        public function duplicate3d($id)
    {
         $product = ProductCustomization::findOrFail($id);
         
        $newProduct = $product->replicate();
        $newProduct->name = 'Copy of ' . $product->name; // Modify any attributes as needed
        // $newProduct->module_id = $product->	module_id;
        $newProduct->product_id = null;
        // $newProduct->user_id = $product->user_id;
        // $newProduct->status = $product->status;
        // $newProduct->created_at = \Carbon\Carbon::now()->toDateTimeString();
        // $newProduct->updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $newProduct->save();
            
     
      $relatedValues = DB::table('CustomizationAttributeValues')
                        ->where('product_customization_id', $id)
                        ->get();

    foreach ($relatedValues as $value) {
        DB::table('CustomizationAttributeValues')->insert([
            'product_customization_id' => $newProduct->id,
            'modules_attribute_id' => $value->modules_attribute_id,
            'modules_attribute_value_id' => $value->modules_attribute_value_id,
          
        ]);
    }


        // You may also need to duplicate any related data, such as images or tags, depending on your application's structure.

        return redirect()->to('admin/product-customizations')->with('success', 'Product duplicated successfully.');
    }


}
