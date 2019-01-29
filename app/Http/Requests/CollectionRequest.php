<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectionRequest extends FormRequest
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
            'service_type.required' => 'The Service Type: field is required.',
            'notice_period.required'  => 'The Notice Period: field is required.',
            'notice_period.integer'  => 'The Notice Period: must be an integer.',
            'notice_period.min'  => 'The Notice Period: must be at least 0.',
            'category.required'  => 'The Category: field is required.',
            'category.integer'  => 'The Category: must be an integer.',
            'name_en.required' => 'The Name En: field is required.',
            'name_en.string'  => 'The Name En: must be a string.',
            'name_en.max'  => 'The Name En: may not be greater than 255 characters.',
            'name_ar.required' => 'The Name Ar: field is required.',
            'name_ar.string'  => 'The Name Ar: must be a string.',
            'name_ar.max'  => 'The Name Ar: may not be greater than 255 characters.',
            'description_en.required' => 'The Description En: field is required.',
            'description_en.string'  => 'The Description En: must be a string.',
            'description_ar.required' => 'The Description Ar: field is required.',
            'description_ar.string'  => 'The Description Ar: must be a string.',
            'service_provide_en.required' => 'The Service Provide En: field is required.',
            'service_provide_en.string'  => 'The Service Provide En: must be a string.',
            'service_provide_ar.required' => 'The Service Provide Ar: field is required.',
            'service_provide_ar.string'  => 'The Service Provide Ar: must be a string.',
            'service_presentation_en.required' => 'The Service Presentation En: field is required.',
            'service_presentation_en.string'  => 'The Service Presentation En: must be a string.',
            'service_presentation_ar.required' => 'The Service Presentation Ar: field is required.',
            'service_presentation_ar.string'  => 'The Service Presentation Ar: must be a string.',
            'menu_item.required' => 'The Menu Item: field is required.',
            'menu_item.array' => 'The Menu Item: must be an array.',
            'collection_price.required_unless'  => 'The Collection Price: field is required.',
            'collection_price.numeric'  => 'The Collection Price: must be a number.',
            'collection_price.min'  => 'The Collection Price: must be at least 0.',
            'min_quantity.required_if'  => 'The Min Quantity: field is required.',
            'min_quantity.integer'  => 'The Min Quantity: must be an integer.',
            'min_quantity.min'  => 'The Min Quantity: must be at least 1.',
            'max_quantity.required_if'  => 'The Max Quantity: field is required.',
            'max_quantity.integer'  => 'The Max Quantity: must be an integer.',
            'max_quantity.gte'  => 'The Max Quantity: must be greater than or equal Min Quantity: field.',
            'min_serve_to_person.required_unless'  => 'The Min Serve to Person: field is required.',
            'min_serve_to_person.integer'  => 'The Min Serve to Person: must be an integer.',
            'min_serve_to_person.min'  => 'The Min Serve to Person: must be at least 1.',
            'max_serve_to_person.required_unless'  => 'The Max Serve to Person: field is required.',
            'max_serve_to_person.integer'  => 'The Max Serve to Person: must be an integer.',
            'max_serve_to_person.gte'  => 'The Max Serve to Person: must be greater than or equal Min Serve to Person.',
            'requirements_en.required' => 'The Requirements En: field is required.',
            'requirements_en.string'  => 'The Requirements En: must be a string.',
            'requirements_ar.required' => 'The Requirements Ar: field is required.',
            'requirements_ar.string'  => 'The Requirements Ar: must be a string.',
            'setup_time.required_if'  => 'The Setup Time: field is required.',
            'setup_time.integer'  => 'The Setup Time: must be an integer.',
            'setup_time.min'  => 'The Setup Time: must be at least 1.',
            'max_time.required_if'  => 'The Max Time: field is required.',
            'max_time.integer'  => 'The Max Time: must be an integer.',
            'max_time.gte'  => 'The Max Time: must be greater than or equal Min Quantity.',
            'image.required' => 'The Image: field is required.',
            'image.mimes'            =>  'The image are not supported.',
            'image.max'              =>  "The image may not be greater than 2 Mb.",
            'daily_days.required' => 'The Daily Days: field is required.',
            'daily_days.array' => 'The Daily Days: must be an array.',
            'daily_hours.start.required' => 'The Start Time: field is required.',
            'daily_hours.start.date_format' => 'The Start Time: does not match the format g:i A.',
            'daily_hours.end.required' => 'The End Time: field is required.',
            'daily_hours.end.date_format' => 'The End Time: does not match the format g:i A.',
            'daily_hours.end.after' => 'The End Time: must be a date after Start Time.',
            'flexible_hours.1.start.required' => 'The Start Time: field is required.',
            'flexible_hours.1.start.date_format' => 'The Start Time: does not match the format g:i A.',
            'flexible_hours.1.end.required' => 'The End Time: field is required.',
            'flexible_hours.1.end.date_format' => 'The End Time: does not match the format g:i A.',
            'flexible_hours.1.end.after' => 'The End Time: must be a date after Start Time.',
            'flexible_hours.2.start.required' => 'The Start Time: field is required.',
            'flexible_hours.2.start.date_format' => 'The Start Time: does not match the format g:i A.',
            'flexible_hours.2.end.required' => 'The End Time: field is required.',
            'flexible_hours.2.end.date_format' => 'The End Time: does not match the format g:i A.',
            'flexible_hours.2.end.after' => 'The End Time: must be a date after Start Time.',
            'flexible_hours.3.start.required' => 'The Start Time: field is required.',
            'flexible_hours.3.start.date_format' => 'The Start Time: does not match the format g:i A.',
            'flexible_hours.3.end.required' => 'The End Time: field is required.',
            'flexible_hours.3.end.date_format' => 'The End Time: does not match the format g:i A.',
            'flexible_hours.3.end.after' => 'The End Time: must be a date after Start Time.',
            'flexible_hours.4.start.required' => 'The Start Time: field is required.',
            'flexible_hours.4.start.date_format' => 'The Start Time: does not match the format g:i A.',
            'flexible_hours.4.end.required' => 'The End Time: field is required.',
            'flexible_hours.4.end.date_format' => 'The End Time: does not match the format g:i A.',
            'flexible_hours.4.end.after' => 'The End Time: must be a date after Start Time.',
            'flexible_hours.5.start.required' => 'The Start Time: field is required.',
            'flexible_hours.5.start.date_format' => 'The Start Time: does not match the format g:i A.',
            'flexible_hours.5.end.required' => 'The End Time: field is required.',
            'flexible_hours.5.end.date_format' => 'The End Time: does not match the format g:i A.',
            'flexible_hours.5.end.after' => 'The End Time: must be a date after Start Time.',
            'flexible_hours.6.start.required' => 'The Start Time: field is required.',
            'flexible_hours.6.start.date_format' => 'The Start Time: does not match the format g:i A.',
            'flexible_hours.6.end.required' => 'The End Time: field is required.',
            'flexible_hours.6.end.date_format' => 'The End Time: does not match the format g:i A.',
            'flexible_hours.6.end.after' => 'The End Time: must be a date after Start Time.',
            'flexible_hours.0.start.required' => 'The Start Time: field is required.',
            'flexible_hours.0.start.date_format' => 'The Start Time: does not match the format g:i A.',
            'flexible_hours.0.end.required' => 'The End Time: field is required.',
            'flexible_hours.0.end.date_format' => 'The End Time: does not match the format g:i A.',
            'flexible_hours.0.end.after' => 'The End Time: must be a date after Start Time.'
        ];
    }

    public function rules()
    {
        $rules = [
            'service_type' => 'required',
            'notice_period' => 'required|integer|min:0',
            'category' => 'required|integer',
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'service_provide_en' => 'required|string',
            'service_provide_ar' => 'required|string',
            'service_presentation_en' => 'required|string',
            'service_presentation_ar' => 'required|string',
            'menu' => 'required|array',
            'collection_price' => 'required_unless:category,4|numeric|min:0',
            'min_quantity' => 'required_if:category, 1,3|integer|min:1',
            'max_quantity' => 'required_if:category, 1,3|integer|gte:min_quantity',
            'min_serve_to_person' => 'required_unless:category,4|integer|min:1',
            'max_serve_to_person' => 'required_unless:category,4|integer|gte:min_serve_to_person',
            'setup_time' => 'required_if:category,2|integer|min:1',
            'max_time' => 'required_if:category,2|integer|gte:setup_time',
            'requirements_en' => 'required_if:category,2|string',
            'requirements_ar' => 'required_if:category,2|string',
            'image' => 'required|image|mimes:jpg,png,gif,bmp,jpeg,PNG,JPG,JPEG,GIF,BMP|max:2048'
        ];

        if ($this->id) {

            $rules = [
                'service_type' => 'required',
                'notice_period' => 'required|integer|min:0',
                'category' => 'required|integer',
                'name_en' => 'required|string|max:255',
                'description_en' => 'required|string',
                'name_ar' => 'required|string|max:255',
                'description_ar' => 'required|string',
                'service_provide_en' => 'required|string',
                'service_provide_ar' => 'required|string',
                'service_presentation_en' => 'required|string',
                'service_presentation_ar' => 'required|string',
                'menu' => 'array',
                'collection_price' => 'required_unless:category,4|numeric ',
                'min_quantity' => 'required_if:category, 1,3|integer|min:1',
                'max_quantity' => 'required_if:category, 1,3|integer|gte:min_quantity',
                'min_serve_to_person' => 'required_unless:category,4|integer|min:1',
                'max_serve_to_person' => 'required_unless:category,4|integer|gte:min_serve_to_person',
                'setup_time' => 'required_if:category,2|integer|min:1',
                'max_time' => 'required_if:category,2|integer|gte:setup_time',
                'requirements_en' => 'required_if:category,2|string',
                'requirements_ar' => 'required_if:category,2|string'
            ];
            if($this->hasFile('image')){
                $rules['image'] = 'image|mimes:jpg,png,gif,bmp,jpeg,PNG,JPG,JPEG,GIF,BMP|max:2048';
            }

            if($this->has('is_available')){
                if($this->is_available == 1){
                    $rules = [
                        'is_available' => 'required|integer'
                    ];
                }
                if($this->is_available == 0){
                    if($this->type == 'daily'){
                        $rules = [
                            'daily_days' => 'required|array',
                            'daily_hours.start' => 'required|date_format:g:i A',
                            'daily_hours.end' => 'required|date_format:g:i A|after:daily_hours.start'
                        ];
                    }
                    if($this->type == 'flexible'){

                        $rules = [
                            'flexible_hours.1.start' => 'required|date_format:g:i A',
                            'flexible_hours.1.end' => 'required|date_format:g:i A|after:flexible_hours.1.start',
                            'flexible_hours.2.start' => 'required|date_format:g:i A',
                            'flexible_hours.2.end' => 'required|date_format:g:i A|after:flexible_hours.2.start',
                            'flexible_hours.3.start' => 'required|date_format:g:i A',
                            'flexible_hours.3.end' => 'required|date_format:g:i A|after:flexible_hours.3.start',
                            'flexible_hours.4.start' => 'required|date_format:g:i A',
                            'flexible_hours.4.end' => 'required|date_format:g:i A|after:flexible_hours.4.start',
                            'flexible_hours.5.start' => 'required|date_format:g:i A',
                            'flexible_hours.5.end' => 'required|date_format:g:i A|after:flexible_hours.5.start',
                            'flexible_hours.6.start' => 'required|date_format:g:i A',
                            'flexible_hours.6.end' => 'required|date_format:g:i A|after:flexible_hours.6.start',
                            'flexible_hours.0.start' => 'required|date_format:g:i A',
                            'flexible_hours.0.end' => 'required|date_format:g:i A|after:flexible_hours.0.start'
                        ];
                    }

                    if ($this->type == '24_7') {

                        $rules = [
                            'type' => 'required|string'
                        ];
                    }
                }
            }
        }

        return $rules;


    }
}
