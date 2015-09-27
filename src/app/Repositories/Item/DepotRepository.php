<?php namespace PCI\Repositories\Item;

use PCI\Models\AbstractBaseModel;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\Item\DepotRepositoryInterface;
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
     * Busca algun Elemento segun Id u otra regla.
     * @param  string|int $id El identificador unico (slug|name|etc|id).
     * @return \PCI\Models\AbstractBaseModel
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * Persiste informacion referente a una entidad.
     * @param array $data El array con informacion del modelo.
     * @return \PCI\Models\AbstractBaseModel
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
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
        // TODO: Implement delete() method.
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
            return sprintf('%-s%s', $depot->number, $depot->rack);
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
