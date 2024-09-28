<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post') && $this->routeIs('register.store')){
            return [
                'username' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed',
                'phone' => 'required',
            ];
        }
       else if ($this->isMethod('put') && $this->routeIs('users.update')){
            return [
                'username' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'type' => 'required',
                'id' => 'required',
            ];
        }
        elseif($this->isMethod('post') && $this->routeIs('login.post')){
            return[
            'email' => 'required',
            'password' => 'required',
                ];
        }
            return [];


    }
}
