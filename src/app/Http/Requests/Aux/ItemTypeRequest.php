<?php namespace PCI\Http\Requests\Aux;

/**
 * Class ItemTypeRequest
 *
 * @package PCI\Http\Requests\Aux
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemTypeRequest extends AbstractAuxRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // necesitamos saber las reglas especificas del tipo de item
        $customRules = $this->getCustomRules();

        $generic = [
            'perishable' => 'required',
        ];

        // unimos las reglas
        return array_merge($customRules, $generic);
    }

    private function getCustomRules()
    {
        if ($this->isMethod('POST')) {
            return [
                'desc' => 'required|string|max:255|unique:item_types',
            ];
        }


        return [
            'desc' => 'required|string|max:255|unique:item_types,desc,'
                . (int)$this->route('itemTypes'),
        ];
    }
}
