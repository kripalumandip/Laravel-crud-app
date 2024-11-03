<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    //This method will show products page
    public function index() {
        $products = Product::orderBy('created_at','DESC')->get();
        return view('products.list',[
            'products' => $products
        ]);
    }

    //This method will show create product page
    public function create() {
        return view('products.create');
    }

    //This method will store a product in db
    public function store(Request $request) {
        //Here we validate date before inserting in db
        $rules = [
            'name' => 'required | min:3',
            'sku' => 'required | min:3',
            'price' => 'required | numeric'
        ];
        
        if($request->image != ""){
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        //Here we will insert product in db
        $product = new Product;
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if($request->image != ""){
            //Here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; //Unique image name
            
            //Save image to products directory
            $image->move(public_path('uploads/products'),$imageName);
    
            //Save image name in database
            $product->image = $imageName;
            $product->save();
        }


        return redirect()->route('products.index')->with('success','Product added successfully.');
    }

    //This method will edit product page
    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('products.edit',[
            'product' => $product
        ]);
    }

    //This method will update product page
    public function update($id, Request $request) {

        $product = Product::findOrFail($id);
        //Here we validate date before inserting in db
        $rules = [
            'name' => 'required | min:3',
            'sku' => 'required | min:3',
            'price' => 'required | numeric'
        ];
        
        if($request->image != ""){
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('products.edit',$product->id)->withInput()->withErrors($validator);
        }

        //Here we will update product in db
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        if($request->image != ""){
            //Delete old image
            File::delete(public_path('uploads/products/'.$product->image));
            //Here we will store image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; //Unique image name
            
            //Save image to products directory
            $image->move(public_path('uploads/products'),$imageName);
    
            //Save image name in database
            $product->image = $imageName;
            $product->save();
        }


        return redirect()->route('products.index')->with('success','Product updated successfully.');
    }

    //This method will delete a product
    public function destroy ($id) {
        $product = Product::findOrFail($id);

        //delete image
        File::delete(public_path('uploads/products/'.$product->image));

        //delete product from db
        $product->delete();

        return redirect()->route('products.index')->with('success','Product deleted successfully');
    }
}
