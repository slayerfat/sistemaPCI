<?php namespace PCI\Repositories\Note;

use Date;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\Note\NoteRepositoryInterface;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;

/**
 * Class NoteRepository
 *
 * @package PCI\Repositories\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteRepository extends AbstractRepository implements NoteRepositoryInterface
{

    /**
     * @var \PCI\Models\Note
     */
    protected $model;

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     *
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        return new ViewPaginatorVariable($this->getTablePaginator(), 'notes');
    }

    /**
     * Genera un objeto LengthAwarePaginator con todos los
     * modelos en el sistema y con eager loading (si aplica).
     *
     * @param int $quantity la cantidad a mostrar por pagina.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTablePaginator($quantity = 25)
    {
        // TODO: eager loading
        $results = $this->getAll();

        return $this->generatePaginator($results, $quantity);
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getAll()
    {
        $user = $this->getCurrentUser();

        if (!$user->isAdmin()) {
            return $this->model->all();
        }

        return $this->model->whereUserId($user->id)->get();
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     *
     * @param  string|int $id El identificador unico (slug|name|etc|id).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        return $this->getById($id);
    }

    /**
     * Persiste informacion referente a una entidad.
     *
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function create(array $data)
    {
        $note = $this->model->newInstance();

        // FIXME: esperando por analisis
        $note->to_user_id   = $note->attendant_id = $data['to_user_id'];
        $note->comments     = $data['comments'];
        $note->petition_id  = $data['petition_id'];
        $note->note_type_id = $data['note_type_id'];
        $note->creation     = Date::now();

        // asociamos la peticion al usuario en linea.
        $this->getCurrentUser()->notes()->save($note);

        // Añade los items solicitados y sus cantidades a la
        // tabla correspondiente en la base de datos.
        foreach ($data['items'] as $id => $data) {
            $note->items()->attach($id, [
                'quantity'      => $data['amount'],
                'stock_type_id' => $data['type'],
            ]);
        }

        return $note;
    }

    /**
     * Actualiza algun modelo y lo persiste
     * en la base de datos del sistema.
     *
     * @param int   $id   El identificador unico.
     * @param array $data El arreglo con informacion relacionada al modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina del sistema un modelo.
     *
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Genera la data necesaria que utilizara el paginator,
     * contiene los datos relevantes para la tabla, esta
     * informacion debe ser un array asociativo.
     * Como cada repositorio contiene modelos con
     * estructuras diferentes, necesitamos
     * manener este metodo abstracto.
     *
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\Note $model
     * @return array<string, string> En donde el key es el titulo legible del
     *                       campo.
     */
    protected function makePaginatorData(AbstractBaseModel $model)
    {
        return [
            'uid'             => $model->id,
            '#'               => $model->id,
            'Tipo'            => $model->type->desc,
            'Pedido #'        => $model->id,
            'Solicitado por'  => $model->requestedBy->name
                . ', '
                . $model->requestedBy->email,
            'Dirigido a'      => $model->toUser ? $model->toUser->name : '-',
            'Encargado'       => $model->attendant->user->name
                . ', '
                . $model->attendant->user->email,
            'Items asociados' => "{$model->items->count()} Items",
            'Estatus'         => $model->status,
        ];
    }
}
