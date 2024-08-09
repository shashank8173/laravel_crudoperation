<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    //this method will show  product page
    public function index(){
        return view('products.list');
    }
    //this method will show create product page
    public function create(){
          return view('products.create');
    }
    //this method will store a product in db
    public function store(Request $request){
        $rules=[
            'name'=>'required|min:5',
            'sku'=>'required|min:3',
            'price'=>'required|numeric'
        ];

        if($request->image !=""){
            $rules['image']='image';
        }
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }
        //here we will insert product in db
        $product= new Product();
        $product->name=$request->name;
        $product->sku=$request->sku;
        $product->price=$request->price;
        $product->description=$request->description;
        $product->save();
        
        if($request->image !=""){
            //here we will store image

        $image=$request->image;
        $ext=$image->getClientOriginalExtension();
        $imageName=time().'.'.$ext; //Unique image name

        //save image to products diretory
        $image->move(public_path('uploads/products'),$imageName);
        //save  image name in database
        $product->image=$imageName;
        $product->save();
        }
        //here we will name in database
        return redirect()->route('products.index')->with('success','Product added successfully.');
    }
    //this method will show edit product page
    public function edit(){

    }
    //this method will update a product
    public function update(){

    }
    //this method will delete a product
    public function destroy(){
        
    }
}
