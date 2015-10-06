<?php namespace PCI\Repositories\User;

use Carbon\Carbon;
use Gate;
use PCI\Models\AbstractBaseModel;
use PCI\Models\Petition;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\Item\ItemRepositoryInterface;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;

/**
 * Class PetitionRepository
 * @package PCI\Repositories\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionRepository extends AbstractRepository implements PetitionRepositoryInterface
{

    /**
     * En esta caso es una peticion
     * @var \PCI\Models\Petition
     */
    protected $model;

    /**
     * La implementacion del repositorio de items
     * @var \PCI\Repositories\Interfaces\Item\ItemRepositoryInterface
     */
    private $itemRepo;

    /**
     * Genera una nueva instancia de este repositorio
     * @param \PCI\Models\AbstractBaseModel $model
     * @param \PCI\Repositories\Interfaces\Item\ItemRepositoryInterface $itemRepo
     */
    public function __construct(AbstractBaseModel $model, ItemRepositoryInterface $itemRepo)
    {
        parent::__construct($model);

        $this->itemRepo = $itemRepo;
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        return new ViewPaginatorVariable($this->getTablePaginator(), 'petitions');
    }

    /**
     * Genera un objeto LengthAwarePaginator con todos los
     * modelos en el sistema y con eager loading (si aplica).
     * @param int $quantity la cantidad a mostrar por pagina.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTablePaginator($quantity = 25)
    {
        return $this->generatePaginator($this->getAll(), $quantity);
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getAll()
    {
        // debemos saber si el usuario actual en el sistema es
        // administador o no, para saber si debemos
        // devolver todas las peticiones o no.
        $user = $this->getCurrentUser();

        if ($user->isAdmin()) {
            return $this->model->all();
        }

        return $this->model->whereUserId($user->id)->get();
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id El identificador unico (slug|name|etc|id).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        return $this->getById($id);
    }

    /**
     * Persiste informacion referente a una entidad.
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\AbstractBaseModel|\PCI\Models\Petition
     */
    public function create(array $data)
    {
        $petition = $this->model->newInstance();

        // esta informacion no nos interesa al
        // momento de crear los items asociados.
        $petition->comments         = $data['comments'];
        $petition->petition_type_id = $data['petition_type_id'];
        $petition->request_date     = Carbon::now();

        // asociamos la peticion al usuario en linea.
        $this->getCurrentUser()->petitions()->save($petition);

        return $this->attachItems($data['items'], $petition);
    }

    /**
     * Añade los items solicitados y sus cantidades a la
     * tabla correspondiente en la base de datos.
     * @param array $items
     * @param \PCI\Models\Petition $petition
     * @return \PCI\Models\Petition
     */
    private function attachItems(array $items, Petition $petition)
    {
        // por cada item dentro de los items, lo asociamos
        // con el modelo en la base de datos.
        foreach ($items as $id => $data) {
            $item = $this->itemRepo->getById($id);

            if (Gate::denies('addItem', [$petition, $item, $data['amount']])) {
                continue;
            }

            $petition->items()->attach($id, [
                'quantity'      => $data['amount'],
                'stock_type_id' => $data['type']
            ]);
        }

        return $petition;
    }

    /**
     * Actualiza algun modelo y lo persiste
     * en la base de datos del sistema.
     * @param int $id El identificador unico.
     * @param array $data El arreglo con informacion relacionada al modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * Elimina del sistema un modelo.
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->delete($id);
    }

    /**
     * Genera la data necesaria que utilizara el paginator,
     * contiene los datos relevantes para la tabla, esta
     * informacion debe ser un array asociativo.
     * Como cada repositorio contiene modelos con
     * estructuras diferentes, necesitamos
     * manener este metodo abstracto.
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\Petition $model
     * @return array<string, string> En donde el key es el titulo legible del campo.
     */
    protected function makePaginatorData(AbstractBaseModel $model)
    {
        // por ahora no necesitamos datos de forma condicional.
        return [
            'uid'                => $model->id,
            'Numero'             => $model->id,
            'Usuario'            => $model->user->name . ' ' . $model->user->email,
            'Tipo'               => $model->type->desc,
            'Fecha de solicitud' => $model->request_date->diffForHumans(),
            'Status'             => $model->status ? 'Aprobado' : 'No Aprobado',
        ];
    }
}
