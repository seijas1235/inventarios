<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\storage;
use App\Photo;
use App\Http\Requests;
use App\OrdenDeTrabajo;
class PhotosController extends Controller
{
    public function store($id, OrdenDeTrabajo $ordendetrabajo, Request $request){
        
        $file = $request->file('photo');
        $path = public_path() . '/images/golpes';
        $fileName = uniqid() . $file->getClientOriginalName();
        
        $file->move($path, $fileName);
        $photoUrl = $path .'/'. $fileName;
        Photo::create([
            'url'=> $photoUrl,
            'orden_id'=> $id,
        ]);
        return $photoUrl;
    }
}
