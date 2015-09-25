<?php namespace PCI\Http\Requests\Aux;

/**
 * Class NationalityRequest
 * @package PCI\Http\Requests\Aux
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NationalityRequest extends AbstractAuxRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'desc' => 'required|string|max:255|unique:nationalities'
        ];
    }
}
