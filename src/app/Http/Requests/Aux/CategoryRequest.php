<?php namespace PCI\Http\Requests\Aux;

/**
 * Class CategoryRequest
 * @package PCI\Http\Requests\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
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
