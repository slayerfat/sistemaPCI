<?php namespace PCI\Http\Requests\User;

use PCI\Http\Requests\Request;

/**
 * Class PetitionRequest
 * @package PCI\Http\Requests\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
