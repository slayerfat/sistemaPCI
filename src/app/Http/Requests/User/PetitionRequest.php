<?php namespace PCI\Http\Requests\User;

use Gate;
use PCI\Http\Requests\Request;
use PCI\Models\Petition;

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
        return Gate::allows('create', new Petition);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        // ajustamos el request
        $this->sanitizeRequest();

        $rules = [
            'comments' => 'string|between:5,255',
            'petition_type_id' => 'numeric|exists:petition_types,id',
        ];

        // debemos chequear que exista al menos un item seleccionado.
        if (count($this->request->get('items')) < 1) {
            $rules['items'] = 'required';
        }

        return $rules;
    }

    /**
     * Crea un array asociativo apropiado para este request.
     * @return void
     */
    private function sanitizeRequest()
    {
        // Debido a que los items solicitados son generados dinamicamente en
        // la vista, no podemos saber cual es el nombre del campo que
        // van a tomar, es por ello que debemos crear un nuevo
        // array que representa la peticion del usuario.
        $comments = $this->request->get('comments');
        $type     = $this->request->get('petition_type_id');

        // removemos los valores que ya no nos interesan.
        $this->request->remove('comments');
        $this->request->remove('petition_type_id');
        $this->request->remove('_token');
        $this->request->remove('itemList');

        // 'limpiamos' los items
        $items = $this->sanitizeItemBag($this->request->all());

        // remplazamos el request por uno a nuestra conveniencia.
        $this->request->replace([
            'comments'         => $comments,
            'petition_type_id' => $type,
            'items'            => $items
        ]);
    }

    /**
     * Como el id del item viene de forma irregular del formulario,
     * se manipula y regresa un array asociativo con id => catidad.
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

            // como esta llegando en este array el tipo de stock,
            // debemos chequear que estamos manipulando
            // el item y no el tipo de stock.
            if ($id[0] == 'item') {
                $results[$id[2]] = [
                    'amount' => $value
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
}
