<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;

class PhotoController extends Controller
{
    //





    public function returnImgPath ($id){

        $imgPath = Photo::find($id)->path;

      return view('photo',compact('imgPath') );
    }






}
