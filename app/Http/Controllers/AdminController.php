<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
    	return view ('admin.dashboard'); 
    }

    public function newcategory()
    {
    	return view('admin.newcategory');
    }


    public function newcategory2(Request $request)
    {


        Category::create([
//            'column name'=>'input / value'
            'name'=>$request->name,
            'discount'=>$request->discount,
            'status'=>$request->status,
        ]);
    return redirect()->back();
    }


    public function categorylist()
    {
        $all_categories=Category::get();
        return view('admin.categorylist',compact('all_categories'));
    }



     public function newproduct()
    {
        $categories=Category::all();

       return view('admin.newproduct',compact('categories'));
    }


    public function newproduct2(Request $request)
    {


    	$file_name = '';
        if ($request->hasFile('image')) {
            
            $product = $request->file('image');
            if ($product->isValid()) {
                //generate file name
                $file_name = date('Ymdhms').'.'.$product->getClientOriginalName();
                //store into directory
                $product->storeAs('product', $file_name);
            }
        }
        
    	Product::create([
        'category_id'=>$request->product_category,
        'name'=>$request->name,
        'for_whom'=>$request->whom,

        'price'=>$request->price,
        'description'=>$request->description,
        'stock'=>$request->stock,
        'nview'=>0,
        'nbuy'=>0,
       'product_image'=>$file_name,
    ]);
    return redirect()->back()->with('message','Product Created Successfully.');

    	
    }
}
