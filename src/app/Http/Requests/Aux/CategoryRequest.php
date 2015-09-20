<?php namespace PCI\Http\Requests\Aux;

use Illuminate\Auth\Guard;
use PCI\Http\Requests\Request;

class CategoryRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     * @param \Illuminate\Auth\Guard $auth
     * @return bool
     */
    public function authorize(Guard $auth)
    {
        return $auth->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'desc' => 'required|string|max:255|unique:categories'
        ];
    }
}
