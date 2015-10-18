<?php namespace PCI\Http\Requests\Traits;

trait SanitizeItemsRequestTrait
{

    /**
     * Crea un array asociativo apropiado para este request.
     *
     * @return void
     */
    private function sanitizeRequest()
    {
        // 'limpiamos' los items
        $items = $this->sanitizeItemBag($this->request->all());

        // remplazamos el request por uno a nuestra conveniencia.
        $this->request->add([
            'items'    => $items,
        ]);
    }

    /**
     * Como el id del item viene de forma irregular del formulario,
     * se manipula y regresa un array asociativo con id => catidad.
     *
     * @param array $data
     * @return array[] Array de [item_id => [cantidad, tipo]]
     */
    private function sanitizeItemBag(array $data)
    {
        $results = [];

        foreach ($data as $key => $value) {
            // si por alguna razon no hay monto o el
            // monto es menor a uno, se ignora este item.
            if ($value < 1) {
                continue;
            }

            // debido a que el key viene en el formato item-id-numero,
            // debemos explotarlo para obtener el id como tal.
            // (ver si se puede mejorar)
            $id = explode('-', $key);

            // si el id no exploto, entonces estamos
            // lidiando con un key desconocido.
            if (count($id) <= 1) {
                continue;
            }

            // como esta llegando en este array el tipo de stock,
            // debemos chequear que estamos manipulando
            // el item y no el tipo de stock.
            if ($id[0] == 'item') {
                $results[$id[2]] = [
                    'amount' => $value,
                ];

                continue;
            }

            // como existe la posibilidad que la cantidad sea menor a
            // 1 debemos chequear si el key con el id existe,
            // entonces se asigna el tipo, de lo
            // contrario se ignora.
            if (isset($results[$id[3]])) {
                $results[$id[3]]['type'] = $value;
            }
        }

        return $results;
    }

    /**
     * Chequea que los items en el request sea al menos 1
     *
     * @param array $rules
     */
    private function checkItems(array &$rules)
    {
        // debemos chequear que exista al menos un item seleccionado.
        if (count($this->request->get('items')) < 1) {
            $rules['items'] = 'required';
        }
    }
}
