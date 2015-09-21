<?php namespace PCI\Http\Requests\Aux;

class CategoryRequest extends AbstractAuxRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules()
    {
        return [
            'desc' => 'required|string|max:255|unique:categories'
        ];
    }
}
