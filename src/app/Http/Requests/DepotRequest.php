<?php namespace PCI\Http\Requests;

/**
 * Class DepotRequest
 * @package PCI\Http\Requests
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class DepotRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'required|between:1,2|integer|unique_with:depots,rack,shelf',
            'user_id' => 'required|integer|exists:users,id',
            'rack'   => 'required|integer|min:1',
            'shelf'  => 'required|integer|min:1',
        ];
    }
}
