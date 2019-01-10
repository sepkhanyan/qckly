<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'name.required' => 'The Name: field is required.',
            'name.string' => 'The Name: must be a string.',
            'name.max'  => 'The Name: may not be greater than 255 characters.',
            'email.email' => 'The Email: must be a valid email address.',
            'email.required' => 'The Email: field is required.',
            'email.unique'     => 'The Email: has already been exists.',
            'username.required' => 'The Username: field is required.',
            'username.regex' => 'The Username: format is invalid.',
            'image.mimes'  =>  'The image are not supported.',
            'image.max' =>  "The image may not be greater than 2 Mb.",
            'password.min'     =>  'The Password: must be at least 6 characters.',
            'password.string'   =>  'The Password: must be a string.',
            'password.confirmed'   =>  'The Password: confirmation does not match.',
        ];
    }

    public function rules()
    {
       $rules =  [
           'name' => 'required|string|max:255',
           'email' => 'required|email|max:255|unique:users,email,' . $this->id,
           'username' => 'required|regex:/^[\s\w-]*$/'
        ];

        if($this->hasFile('image')){
            $rules['image'] = 'image|mimes:jpg,png,gif,bmp,jpeg,PNG,JPG,JPEG,GIF,BMP|max:2048';
        }

        if($this->password != null){
            $rules['password'] = 'string|min:6|confirmed';
        }

       return $rules;
    }
}
