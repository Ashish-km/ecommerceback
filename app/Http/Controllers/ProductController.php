<?php

namespace App\Http\Controllers;
use app\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller

{

    public function add (Request $request){
    $validator=Validator::make($request->all(),[
         'name' => 'required',
         'category' => 'required',
         'brand' => 'required',
         'desc' => 'requird',
         'image' => 'requird|image',
         'price' => 'requird',
    ]);

    if ($validator  -> fails()){
        return response()-> json(['error'=>$validator->errors()->all()],status:409);
    }
    $p =new product();
    $p->name=$request->name;
    $p->category=$request->category;
    $p->brand=$request->brand;
    $p->desc=$request->desc;
    $p->image=$request->image;
    $p->save();

    $url="http://localhost:8000/storage/";
    $file = $request->file(key: 'image');
    $extension = $file->getClientOriginalExtension();
    $path = $request->file( key: 'image')->storeAs(path: 'proimages/', name: $p->id.'.'.$extension);
    $p->image-$path;
    $p->imgpath=$url.$path;
    $p->save();
      }

      public function  update(Request $request){
        $validator=Validator::make($request->all(),[
             'name' => 'required',
             'category' => 'required',
             'brand' => 'required',
             'desc' => 'requird',
             'price' => 'requird',
             'id'=> 'requird',
        ]);

        if ($validator->fails()){
            return response()-> json(['error'=>$validator->errors()->all()],status:409);
        }
        $p =product::find($request->id);
        $p->name=$request->name;
        $p->category=$request->category;
        $p->brand=$request->brand;
        $p->desc=$request->desc;
        $p->image=$request->image;
        $p->save();
    return response()->json(['message'=>'product successfully Updated']);

          }

          public function  delete(Request $request){
            $validator=Validator::make($request->all(),[

                 'id'=> 'requird',
            ]);

            if ($validator -> fails()){
                return response()-> json(['error'=>$validator->errors()->all()],status:409);
            }
           $p =product::find($request->id)->delete();

        return response()->json(['message'=>'product successfully Deleted']);

              }


              public function show(Request $request){
                session(['keys'=>$request->keys]);
                $products=product::where(function ($q){
                    $q->where('products.id', 'LIKE','%'.session( key: 'keys').'%')
                    ->orwhere('products.name','LIKE', '%'.session(key: 'keys').'%')
                    ->orwhere('products.price','LIKE','%'.session( key: 'keys').'%')
                    ->orwhere('products.category', 'LIKE', '%' .session( key: 'keys').'%')
                    ->orwhere('products.brand', 'LIKE', '%' .session( key: 'keys').'%');
                        })->select('products.*')->get();
                    return response()->json(['products'=>$products]);
              }


}
