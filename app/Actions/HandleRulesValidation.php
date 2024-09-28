<?php

namespace App\Actions;
use App\Models\Languages;
use Illuminate\Support\Str;
class HandleRulesValidation
{

    public static function handle($basic,$data_lang){    //basic is the static data that doesn't change between languages
                                                         //data_lang is the changing data and it is sent as ['name:required','info:required']


        $langs=Languages::query()->pluck('prefix');  //[ar,en]
        foreach ($langs as $lang){
            foreach ($data_lang as $item){
                $name=Str::before($item,':');
                $validation=Str::after($item,':');
                $basic[$lang.'_'.$name]=$validation;
            }
        }
        return $basic;
    }

    public static function handle_inputs_langs($all,$decoded){
        $langs = languages::query()->select('prefix')->get()->map(function ($e){
            return $e->prefix;
        });
        $output = [];
        foreach($all as $name => $value){
            $exist_inner_arr = 0;
            foreach ($langs as $lang) {
                if (Str::contains($name, $lang)) {
                    $input_name = Str::replace($lang,'',$name);
                    $input_name = Str::replace('_','',$input_name);
                    $output[$input_name][$lang] = $value;
                    $exist_inner_arr = 1;
                }
            }
            if($exist_inner_arr == 0){
                $output[$name] = $value;
            }
        }
        foreach ($decoded as $value){
            $output[$value] = json_encode($output[$value],JSON_UNESCAPED_UNICODE);
        }
        return $output;
    }


}

