<?php namespace PCI\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use PCI\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractRepository
{

    /**
     * El modelo a ser manipulado
     *
     * @var Model
     */
    protected $model;

    /**
     * El usuario en linea.
     *
     * @var User
     */
    protected $currentUser;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getBySlugOrId($id)
    {
        return $this->getByIdOrAnother($id, 'slug');
    }

    /**
     * @param  mixed $id
     *
     * @return Model
     */
    public function getByNameOrId($id)
    {
        return $this->getByIdOrAnother($id, 'name');
    }

    /**
     * @param  mixed $id
     *
     * @return Model
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
     * @return Model
     */
    protected function newInstance(array $data = [])
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
     *
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
     */
    protected function executeForceDestroy($id, $resource = 'Recurso', $child = 'Recursos')
    {
        $model = $this->model->withTrashed()->findOrFail($id);

        return $this->deleteDestroyPrototype($model, $resource, $child, 'forceDelete');
    }

    /**
     * @param Model $model
     * @param $resource
     * @param $child
     * @param $method
     * @return bool|Model
     * @throws HttpException
     */
    private function deleteDestroyPrototype(Model $model, $resource, $child, $method)
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
}
