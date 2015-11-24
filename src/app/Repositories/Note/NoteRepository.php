<?php namespace PCI\Repositories\Note;

use Exception;
use PCI\Mamarrachismo\Collection\ItemCollection;
use PCI\Models\AbstractBaseModel;
use PCI\Models\Note;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use PCI\Repositories\Interfaces\Note\NoteRepositoryInterface;
use PCI\Repositories\Traits\CanChangeStatus;
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

    use CanChangeStatus;

    /**
     * La nota asociada a manipular.
     *
     * @var \PCI\Models\Note
     */
    protected $model;

    /**
     * @var \PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface
     */
    private $typeRepo;

    /**
     * Genera una nueva instancia de este repositorio
     *
     * @param \PCI\Models\AbstractBaseModel $model
     * @param NoteTypeRepositoryInterface   $typeRepo
     */
    public function __construct(
        AbstractBaseModel $model,
        NoteTypeRepositoryInterface $typeRepo
    ) {
        parent::__construct($model);

        $this->typeRepo = $typeRepo;
    }

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

        if ($user->isAdmin()) {
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

        // asociamos la peticion al usuario en linea.
        $this->getCurrentUser()->notes()->save($note);

        try {
            // Añade los items solicitados y sus cantidades a la
            // tabla correspondiente en la base de datos.
            $this->attachDetails($data['itemCollection'], $note);
        } catch (Exception $e) {
            $note->status = false;
            $note->save();
        }

        return $note;
    }

    /**
     * @param ItemCollection $items
     * @param Note           $note
     */
    private function attachDetails(ItemCollection $items, Note $note)
    {
        foreach ($items as $id => $data) {
            foreach ($data as $details) {
                $note->items()->attach($id, [
                    'quantity'      => $details['amount'],
                    'stock_type_id' => $details['stock_type_id'],
                    'due'           => $details['due'],
                ]);
            }
        }
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
     * Collection de tipos segun el perfil del usuario.
     *
     * @return \Illuminate\Support\Collection
     */
    public function typeList()
    {
        return $this->typeRepo->lists();
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
            'Creador'         => $model->user->name
                . ', '
                . $model->user->email,
            'Dirigido a'      => $model->toUser ? $model->toUser->name : '-',
            'Encargado'       => $model->attendant->user->name
                . ', '
                . $model->attendant->user->email,
            'Items asociados' => "{$model->items->count()} Items",
            'Estatus'         => $model->formattedStatus,
        ];
    }
}
