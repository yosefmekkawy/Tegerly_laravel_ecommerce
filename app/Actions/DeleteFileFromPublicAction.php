<?php

namespace App\Actions;

class DeleteFileFromPublicAction
{
    public static function delete($folder,$name){
        $file_path=public_path($folder.'/'.$name);
        if(file_exists($file_path)){
            unlink($file_path);
        }
    }
}
