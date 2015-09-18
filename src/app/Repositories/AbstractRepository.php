<?php namespace PCI\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Models\AbstractBaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractRepository
{

    /**
     * El modelo a ser manipulado
     *
     * @var \PCI\Models\AbstractBaseModel
     */
    protected $model;

    /**
     * El usuario en linea.
     *
     * @var \PCI\Models\User
     */
    protected $currentUser;

    /**
     * @param \PCI\Models\AbstractBaseModel $model
     */
    public function __construct(AbstractBaseModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param  string|int $id
     *
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getBySlugOrId($id)
    {
        return $this->getByIdOrAnother($id, 'slug');
    }

    /**
     * @param  mixed $id
     *
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getByNameOrId($id)
    {
        return $this->getByIdOrAnother($id, 'name');
    }

    /**
     * @param  mixed $id
     *
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getById($id)
    {
        $this->checkId($id);

        return $this->model->findOrFail($id);
    }

    /**
     * Devuelve una nueva instancia del modelo (Products, User, etc).
     *
     * @param  array $data
     *
     * @return \PCI\Models\AbstractBaseModel
     */
    public function newInstance(array $data = [])
    {
        return $this->model->newInstance($data);
    }

    /**
     * @return null|\PCI\Models\User
     */
    protected function getCurrentUser()
    {
        if (!isset($this->currentUser) || is_null($this->currentUser)) {
            $this->currentUser = auth()->user();
        }

        $this->currentUser = auth()->user();

        return $this->currentUser;
    }

    /**
     * @param $id
     *
     * @return void
     * @throws HttpException
     */
    protected function checkId($id)
    {
        if (is_null($id) || trim($id) == '') {
            throw new HttpException(
                '400',
                'Es necesario un identificador para continuar con el proceso.'
            );
        }
    }

    /**
     * @param $id
     * @internal Laravels Policies hacen esto irrelevante.
     * @deprecated Laravels ACL.
     * @todo remover.
     * @return bool
     */
    protected function canUserManipulate($id)
    {
        if (!isset($this->currentUser)) {
            $this->getCurrentUser();
        }

        if (is_null($this->currentUser)) {
            return false;
        }

        return $this->currentUser->isOwnerOrAdmin($id);
    }

    /**
     * @param $id
     * @param string $column
     * @return mixed
     */
    protected function getByIdOrAnother($id, $column)
    {
        $this->checkId($id);

        $model = $this->model
            ->where($column, $id)
            ->orWhere('id', $id)
            ->firstOrFail();

        return $model;
    }

    /**
     * Elimina del sistema (soft) algun recurso
     * y genera un flash de exito o fracaso.
     * adicionalmente ataja error de tabla con
     * hijos o genera exception cuando sea otro.
     * @param int $id
     * @param string $resource
     * @param string $child
     * @return bool|Model
     */
    protected function executeDelete($id, $resource = 'Recurso', $child = 'Recursos')
    {
        $model = $this->getById($id);

        return $this->deleteDestroyPrototype($model, $resource, $child, 'delete');
    }

    /**
     * Elimina del sistema (forceful) algun recurso
     * y genera un flash de exito o fracaso.
     * adicionalmente ataja error de tabla con
     * hijos o genera exception cuando sea otro.
     * @param int $id
     * @param string $resource
     * @param string $child
     * @return bool|Model
     * @internal el sistema no deberia tener softdeletes. FIXME
     */
    protected function executeForceDestroy($id, $resource = 'Recurso', $child = 'Recursos')
    {
        // withTrashed()
        $model = $this->model->findOrFail($id);

        return $this->deleteDestroyPrototype($model, $resource, $child, 'forceDelete');
    }

    /**
     * @param \PCI\Models\AbstractBaseModel $model
     * @param $resource
     * @param $child
     * @param $method
     * @return bool|Model
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function deleteDestroyPrototype(AbstractBaseModel $model, $resource, $child, $method)
    {
        try {
            $model->$method();
        } catch (Exception $e) {
            if ($e instanceof QueryException || $e->getCode() == 23000) {
                flash()->error("No deben haber {$child} asociados.");

                return $model;
            }

            throw new HttpException(500, "No se pudo eliminar al {$resource}, error inesperado.", $e);
        }

        flash()->success("El {$resource} ha sido eliminado correctamente.");

        return true;
    }

    /**
     * Genera un objeto LengthAwarePaginator con una coleccion paginada.
     * @link http://stackoverflow.com/a/29527744
     * @param \Illuminate\Database\Eloquent\Collection $results
     * @param int $quantity
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function generatePaginator(Collection $results, $quantity = 25)
    {
        $page = \Input::get('page', 1);

        $items = $this->generatePaginatorContents($results);

        return new LengthAwarePaginator(
            $items->forPage($page, $quantity),
            $items->count(),
            $quantity,
            $page
        );
    }

    /**
     * Itera la coleccion y genera la informacion final
     * que se vera en la tabla de index.
     * @param \Illuminate\Database\Eloquent\Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function generatePaginatorContents(Collection $results)
    {
        $array = collect();

        $results->each(function ($model) use (&$array) {
            $data = $this->makePaginatorData($model);

            $array->push($data);
        });

        return $array;
    }

    /**
     * Genera la data necesaria que utilizara el paginator,
     * contiene los datos relevantes para la tabla, esta
     * informacion debe ser un array asociativo.
     * @param \PCI\Models\AbstractBaseModel $model
     * @return array<string, string> En donde el key es el titulo legible del campo.
     */
    abstract protected function makePaginatorData(AbstractBaseModel $model);
}
