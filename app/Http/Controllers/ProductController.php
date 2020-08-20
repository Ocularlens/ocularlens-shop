<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    //

    public function index()
    {
        $products = Product::all(); 
        return view('admin.products.index')->with([
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'max:100',
            'price' => 'required',
            'files' => 'mimes:jpg,jpeg,png,gif,tiff,raw',
            'quantity' => 'required|min:1'
        ],
        [
            'name.required' => 'Field required',
            'name.max' => 'Max length is 50',
            'description.max' => 'Max length is 100',
            'price.required' => 'Field required',
            'quantity.required' => 'Field required',
            'quantity.min' => 'Minumum quantity is 1'
        ]);

        $files = $request->file('files');
        $filename =$request['name']. time(). '.'. $files->getClientOriginalExtension();
        $files->move('storage/product/', $filename);

        $product = new Product([
            'item_code' => Hash::make(str_replace(['.','/'],'',$request['name'])),
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'image_path' => $filename,
            'quantity' => $request['quantity'],
        ]);

        $product->save();

        return redirect('/admin/products')->with([
            'message' => 'Product saved'
        ]);
    }

    public function view(Product $product)
    {
        return view('admin.products.edit')->with([
            'product' => $product,
        ]);
    }

    public function edit(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'max:100',
            'price' => 'required',
            'files' => 'mimes:jpg,jpeg,png,gif,tiff,raw',
            'quantity' => 'required|min:1'
        ],
        [
            'name.required' => 'Field required',
            'name.max' => 'Max length is 50',
            'description.max' => 'Max length is 100',
            'price.required' => 'Field required',
            'quantity.required' => 'Field required',
            'quantity.min' => 'Minumum quantity is 1'
        ]);

        if($request->hasFile('files')){
            $files = $request->file('files');
            $files->move('storage/product/', $product->image_path);    
        }

        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        $product->quantity = $request['quantity'];

        $product->save();

        return redirect('/admin/products')->with([
            'message' => 'Product saved'
        ]);
    }
}
