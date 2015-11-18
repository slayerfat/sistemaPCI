<?php namespace PCI\Http\Requests\Traits;

use LogicException;
use PCI\Mamarrachismo\Collection\ItemCollection;

/**
 * Trait SanitizeItemsRequestTrait
 *
 * @package PCI\Http\Requests\Traits
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 * @property \Symfony\Component\HttpFoundation\ParameterBag $request
 */
trait SanitizeItemsRequestTrait
{

    /**
     * regresa un array con los campos necesarios para la coleccion.
     *
     * @return array
     */
    protected abstract function itemCollectionRules();

    /**
     * Genera reglas y la coleccion de items asociados al request.
     *
     * @param array $rules
     */
    private function checkItems(array &$rules)
    {
        // debemos chequear que exista al menos un item seleccionado.
        $data       = $this->request->get('items');
        $collection = new ItemCollection;
        $collection->setRequiredFields($this->itemCollectionRules());

        if (count($data) < 1) {
            $rules['items'] = 'required';

            return;
        }

        // como el input viene como un array multidimensional,
        // debemos iterar a travez de el para generar
        // la coleccion que necesita el repositorio.
        $customRules = $this->makeCustomRules($data, $collection);

        // se guarda un nuevo parametro al request
        $this->request->add([
            'itemCollection' => $collection,
        ]);

        $rules = array_merge($rules, $customRules);
    }

    /**
     * Genera reglas segun cada item dentro del request.
     *
     * @param array          $data [random_id => [item_id => datos]]
     * @param ItemCollection $collection
     * @return array
     */
    private function makeCustomRules(array $data, ItemCollection $collection)
    {
        $customRules = [];

        foreach ($data as $randomId => $array) {
            foreach ($array as $itemId => $details) {
                $newData            = $details;
                $newData['item_id'] = $itemId;
                $collection->push($newData);

                foreach (array_keys($details) as $key) {
                    $customRules["items.$randomId.$itemId.$key"] = $this->makeMsgRules($key);
                }
            }
        }

        return $customRules;
    }

    /**
     * Genera una regla relevante segun el tipo de parametro del request.
     *
     * @param $key
     * @return string
     */
    private function makeMsgRules($key)
    {
        switch ($key) {
            case 'amount':
            case 'stock_type_id':
                $msg = 'numeric';
                break;

            case 'due':
                $msg = 'date';
                break;

            default:
                throw new LogicException("Elemento [$key] desconocido.");
                break;
        }

        return 'required|' . $msg;
    }
}
