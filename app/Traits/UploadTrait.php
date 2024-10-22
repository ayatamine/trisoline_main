<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

Trait UploadTrait
{
    /************ upload main file ******************/
    function saveFile($file , $folder , $fileable_id , $fileable_type , $type, $with_return=false)
    {
        

        $filename = time() . '-' .$file->getClientOriginalName(); 

        Storage::disk('local')->put("$folder/$filename", file_get_contents($file));
        if($with_return)
        {
            return $filename;
        } 
        $albumFile = new File();
        $albumFile->fileable_id = $fileable_id;
        $albumFile->fileable_type = $fileable_type;
        $albumFile->type = $type;
        $albumFile->file = $filename;
        $albumFile->save();
        
    }
    /************ upload multiple files ******************/
    function saveFiles($files , $folder , $fileable_id , $fileable_type , $type, $with_return=false)
    {
        $collected_files = [];
       foreach($files as $file)
       {
       

        $filename = time() . '-' .$file->getClientOriginalName(); 

        Storage::disk('local')->put("$folder/$filename", file_get_contents($file));
        if($with_return)
        {
            array_push($collected_files,$filename);
        }else
        {
            $albumFile = new File();
            $albumFile->fileable_id = $fileable_id;
            $albumFile->fileable_type = $fileable_type;
            $albumFile->type = $type;
            $albumFile->file = $filename;
            $albumFile->save();
        }

       }
       if($with_return)
        {
            return $collected_files;
        }
    }
    /************ edit main file ******************/
    function editFile($file , $folder , $fileable_id , $fileable_type , $type, $with_return=false)
    {
        $file = File::where('fileable_type' , $fileable_type)->where('type', $type)->where('fileable_id' , $fileable_id)->first();
        if(isset($file) && file_exists($folder.'/'. $file->file)){
            @unlink($folder.'/'. $file->file);
            $file->delete();
        }
        

        $filename = time() . '-' .$file->getClientOriginalName(); 

        Storage::disk('local')->put("$folder/$filename", file_get_contents($file));
        if($with_return)
        {
            return $filename;
        }
        $albumFile = new File();
        $albumFile->fileable_id = $fileable_id;
        $albumFile->fileable_type = $fileable_type;
        $albumFile->type = $type;
        $albumFile->file = $filename;
        $albumFile->save();
        
    }
    /**************** delete and unlink images ************/
    function deleteFiles($id , $path , $fileable_type)
    {
        $files = File::where('fileable_id' , $id)->where('fileable_type' , $fileable_type)->get();
        foreach($files as $file){
            if(isset($file)  && file_exists($path.'/'. $file->file) ) @unlink($path . $file->file);
            $file->delete();
        }
    }
}
