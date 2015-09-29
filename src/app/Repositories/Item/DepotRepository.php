<?php namespace PCI\Repositories\Item;

use PCI\Exceptions\Business\UserIsNotAdminException;
use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\Item\DepotRepositoryInterface;
use PCI\Repositories\Interfaces\User\UserRepositoryInterface;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;

/**
 * Class DepotRepository
 * @package PCI\Repositories\Item
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class DepotRepository extends AbstractRepository implements DepotRepositoryInterface
{

    /**
     * @var \PCI\Repositories\Interfaces\User\UserRepositoryInterface
     */
    private $userRepo;

    /**
     * Genera la instancia de esta clase.
     * Esta necesita un modelo, y necesita el repositorio de usuarios.
     * @param \PCI\Models\AbstractBaseModel $model
     * @param \PCI\Repositories\Interfaces\User\UserRepositoryInterface $userRepo
     */
    public function __construct(AbstractBaseModel $model, UserRepositoryInterface $userRepo)
    {
        parent::__construct($model);

        $this->userRepo = $userRepo;
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
     * @return \PCI\Models\AbstractBaseModel
     */
    public function create(array $data)
    {
        $depot = $this->newInstance($data);

        $owner = $this->checkOwner($data);

        $owner->manages()->save($depot);

        return $depot;
    }

    /**
     * Chequea si el id de usuario que viene del formulario
     * es un administrador, si no lo es buta una excepcion.
     * @param array $data el array del request con los datos.
     * @return \PCI\Models\User el modelo del jefe de almacen.
     * @throws \PCI\Exceptions\Business\UserIsNotAdminException
     */
    private function checkOwner(array $data)
    {
        /** @var \PCI\Models\User $owner */
        $owner = $this->userRepo->find($data['user_id']);

        if (!$owner->isAdmin()) {
            throw new UserIsNotAdminException;
        }

        return $owner;
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
        /** @var \PCI\Models\Depot $depot */
        $depot = $this->getById($id);

        $owner = $this->checkOwner($data);
        $depot->fill($data);
        $depot->user_id = $owner->id;
        $depot->save();

        return $depot;
    }

    /**
     * Elimina del sistema un modelo.
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id);
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        $results = $this->getTablePaginator();

        return new ViewPaginatorVariable($results, 'depots');
    }

    /**
     * Genera un objeto LengthAwarePaginator con todos los
     * modelos en el sistema y con eager loading (si aplica)
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
        // por ahora no necesitamos manipular la coleccion.
        return $this->model->all()->sortBy(function ($depot) {
            return sprintf('%s, %s, %s', $depot->number, $depot->rack, $depot->shelf);
        });
    }

    /**
     * Genera la data necesaria que utilizara el paginator,
     * contiene los datos relevantes para la tabla, esta
     * informacion debe ser un array asociativo.
     * Como cada repositorio contiene modelos con
     * estructuras diferentes, necesitamos
     * manener este metodo abstracto.
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\Depot $model
     * @return array<string, string> En donde el key es el titulo legible del campo.
     */
    protected function makePaginatorData(AbstractBaseModel $model)
    {
        // por ahora no necesitamos datos de forma condicional.
        return [
            'uid'               => $model->id,
            'Numero'            => "Nro. $model->number",
            'Anaquel'           => "Nro. $model->rack",
            'Alacena'           => "Nro. $model->shelf",
            'Items Registrados' => "{$model->items->count()} Items"
        ];
    }
}
