<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UploadImage;
use App\User;

class UploadImageController extends Controller
{
    function show($id){
    	$user=User::find($id);
    	$user_id = $id;
    	$upload = UploadImage::find($user_id);
		return view("upload_form", [
            "user" => $user,
            "image" => $upload,
            ]);
	}
	
	function upload(Request $request){
		$request->validate([
			'image' => 'required|file|image|mimes:png,jpeg',
			
		]);
		$upload_image = $request->file('image');
		

		if($upload_image) {
			//アップロードされた画像を保存する
			$path = $upload_image->store('uploads',"public");
			//画像の保存に成功したらDBに記録する
			if($path){
				// UploadImage::create([
				$request->user()->uploadimages()->create([
					"file_name" => $upload_image->getClientOriginalName(),
					"file_path" => $path
				]);
			}
		}
		
		
		return redirect("/");
	}
}
