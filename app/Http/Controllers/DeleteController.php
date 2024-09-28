<?php

namespace App\Http\Controllers;

use App\Actions\DeleteFileFromPublicAction;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
//    public static function Delete(Request $request)
//    {
//        if(request()->filled('model_name') && request()->filled('id'))
//
//            DB::select('DELETE FROM '.request('model_name').' WHERE id='.request('id'));
//        return redirect()->back();
//    }
    public function Delete(Request $request){
        $table = request('model');
        try {
            $model = app("App\Models\\".$table);
            $model->where('id',request('id'))->delete();
        }catch (\Throwable $e){
            if(request()->has('id')) {
                $id = request('id');
                DB::table($table)->delete($id);
            }
        }
        $images_found_check = Images::query()
            ->where('imageable_id','=',request('id'))
            ->where('imageable_type','=','App\Models\\'.$table)->get();
        if ($images_found_check->count() > 0){
            foreach ($images_found_check as $image){
                DeleteFileFromPublicAction::delete('images',$image->name);
            }
        }

        $images_found_check = Images::query()
            ->where('imageable_id','=',request('id'))
            ->where('imageable_type','=','App\Models\\'.$table)->delete();

        return redirect()->back()->with(['message','Item Deleted Successfully']);
//        return messages::success_output(trans('messages.deleted_successfully'));

    }



}
