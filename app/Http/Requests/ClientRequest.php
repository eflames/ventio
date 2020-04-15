<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'id_number' => 'required|max:255|unique:clients,id_number,'.$this->id,
//            'email' => 'max:255|email|unique:clients,email,'.$this->id,
            'telephone' => 'required',
//            'telephone' => 'required|unique:clients,telephone,'.$this->id,
            'address' => 'max:255',
            'comment' => 'max:255'
        ];
    }
}