<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\ThrottleException;
use App\Advert;

class CreateAdvertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Advert());
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function failedAuthorization()
    {
        throw new ThrottleException('Throttle Exception'); // @todo
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city_id' => 'required|exists:cities,id',
            'street_id' => 'sometimes|exists:streets,id',
            'title' => 'required|spamfree|between:3,60',
            'description' => 'required|spamfree|between:50,5000',
            'rent' => 'required|numeric',
            'bills' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
            'room_size' => 'required|in:single,double,triple',
            'available_from' => 'nullable|date',
            'minimum_stay' => 'nullable|numeric|between:1,36',
            'maximum_stay' => 'nullable|numeric|between:1,36',
            'landlord' => 'sometimes|in:live_in,live_out,tenetant,agent,former',
            'property_type' => 'nullable|in:block,house,tenement,apartment,loft',
            'property_size' => 'sometimes|numeric',
            'living_room' => 'sometimes|boolean',
            'parking' => 'sometimes|boolean',
            'furnished' => 'sometimes|boolean',
            'broadband' => 'sometimes|boolean',
            'garage' => 'sometimes|boolean',
            'garden' => 'sometimes|boolean',
            'nonsmoking' => 'nullable|boolean',
            'pets' => 'sometimes|boolean',
            'occupation' => 'nullable|in:student,professional',
            'couples' => 'sometimes|boolean',
            'gender' => 'nullable|in:f,m',
            'minimum_age' => 'nullable|numeric|between:18,99',
            'maximum_age' => 'nullable|numeric|between:18,99',
            'phone' => 'sometimes|digits_between:9,13'
        ];
    }
}
