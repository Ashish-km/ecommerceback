<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function add (Request $request)
           {
    $validator=Validator::make($request->all(),[
         'name' => 'required',
         'category' => 'required',
         'brand' => 'required',
         'desc' => 'requird',
         'image' => 'requird|image',
         'price' => 'requird',
    ]);

    if ($Validator -> fails()){
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
    $p->image-Spath;
    $p->imgpath=Surl.$path;
    $p->save();
}
}
