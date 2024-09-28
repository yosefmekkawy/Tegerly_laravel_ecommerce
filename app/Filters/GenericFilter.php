<?php

namespace App\Filters;
use Closure;
use Illuminate\Support\Str;

class GenericFilter
{
    protected $filter_name;
    protected $operator;

    protected $column;

    protected $value;

    public function __construct($filter_name,$column,$operator,$value)
    {
        $this->filter_name = $filter_name;
        $this->column=$column;
        $this->operator=$operator;
        $this->value=$value;
    }
    public function handle($request, Closure $next)
    {
        if(request()->filled($this->filter_name)){
            if(Str::contains($this->operator,'like')){
                $this->value='%'.$this->value.'%';
            }
            return $next($request)->where($this->column,$this->operator,$this->value);
        }
        return $next($request);
    }

}
