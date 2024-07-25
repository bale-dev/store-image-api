<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Images;

class StoreImageController extends Controller
{

    // Method for storing images
    public function storeImage( Request $request){
        
        

        try {

            // Validate that image file exists in request
            $validateImageFile = Validator::make($request->all(),
            [
                'image_file' => 'required',   
            ]);


            if($validateImageFile->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Image file is missing.',
                    'errors' => $validateImageFile->errors()
                ], 401);
            }


            $image = new Images;

            // Get original image file name
            $image_file = $request->image_file;

            $image_file_name = $image_file->getClientOriginalName();
            



            // Remove unwanted characters form filename
            $image_file_name = str_replace(' ', '-', $image_file_name);
            $image_file_name = str_replace(array('Š', 'š'), 's', $image_file_name);
            $image_file_name = str_replace(array('Ž', 'ž'), 'z', $image_file_name);
            $image_file_name = str_replace(array('Đ', 'đ'), 'd', $image_file_name);
            $image_file_name = str_replace(array('Č', 'č'), 'c', $image_file_name);
            
            // Get file type
            $image_file_type = $image_file->extension();
            
            // Get file size
            $image_file_size =  number_format( $image_file->getSize() / 1048576, 3) . ' MB';
            

            // Set image file name
            $image->image_file_name  = $image_file_name;


            // Check if image name exists in request and is not emtpy 
            if ( is_null( $request->image_name ) || empty( $request->image_name ) ) {
                $image->image_title = $image_file_name;
            } else {
                $image->image_title = $request->image_name;
            }


            // Check if image description exists in request and is not emtpy 
            if ( is_null( $request->image_description ) || empty( $request->image_description ) ) {
                $image->image_description = '';
            } else {
                $image->image_description = $request->image_description;
            }

 
            // Move image to upload folder            
            $image_upload_folder = public_path() . '/images/';
            $image_file->move($image_upload_folder, $image_file_name);
            $image_upload_folder = str_replace('\\', '/', $image_upload_folder );

            // Create image link on server            
            $image_file_path = $image_upload_folder . $image_file_name;
            
            $image_response_array = array(
                'file_type'     => $image_file_type,
                'file_size'     => $image_file_size,
                'file_path'     => $image_file_path,
            );
  

            $image->save();
            
            //Response when image was successfully created
            return response()->json([
                "message" => "Image was successfully stored",
                "response" => $image_response_array
            ], 201);
           
        } catch (\Throwable $th) {
            
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
            
        }
        
    }
}
