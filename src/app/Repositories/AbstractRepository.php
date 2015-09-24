<?php namespace PCI\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use PCI\Models\AbstractBaseModel;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class AbstractRepository
 * @package PCI\Repositories
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractRepository
{

    /**
     * El modelo a ser manipulado
     *
     * @var \PCI\Models\AbstractBaseModel
     */
    protected $model;

    /**
     * Genera la instancia de la clase concreta.
     * Esta necesita un modelo, que es debe
     * Implementar AbstractBaseModel.
     * @param \PCI\Models\AbstractBaseModel $model
     */
    public function __construct(AbstractBaseModel $model)
    {
        $this->model = $model;
    }

    /**
     * Busca en la base de datos algun modelo
     * que tenga un campo slug y/o id.
     * @param  string|int $id

     * @return \PCI\Models\AbstractBaseModel
     */
    public function getBySlugOrId($id)
    {
        return $this->getByIdOrAnother($id, 'slug');
    }

    /**
     * Busca el modelo por alguna columna,
     * adicionalmente al id que este posee.
     * @param string|int $id
     * @param string $column
     * @return \PCI\Models\AbstractBaseModel
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
     * Chequea si el id es valido para ser procesado,
     * de lo contrario bota una excepcion.
     * @param string|int $id
     *
     * @return void
     * @throws HttpException
     */
    protected function checkId($id)
    {
        // por ahora solo se ve si el id es nulo
        // o si es una cadena de texto vacia.
        if (is_null($id) || trim($id) == '') {
            throw new HttpException(
                '400',
                'Es necesario un identificador para continuar con el proceso.'
            );
        }
    }

    /**
     * Busca en la base de datos algun modelo
     * que tenga un campo nombre y/o id.
     * @param  string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getByNameOrId($id)
    {
        return $this->getByIdOrAnother($id, 'name');
    }

    /**
     * Devuelve una nueva instancia del modelo (Products, User, etc).
     * Este modelo debe ser una implementacion de AbstractBaseModel.
     * @param  array $data
     * @return \PCI\Models\AbstractBaseModel
     */
    public function newInstance(array $data = [])
    {
        return $this->model->newInstance($data);
    }

    /**
     * Busca al usuario actual que se encuentra en el sistema.
     * @return \PCI\Models\User|null
     */
    protected function getCurrentUser()
    {
        return auth()->user();
    }

    /**
     * Elimina del sistema (soft) algun recurso
     * y genera un flash de exito o fracaso.
     * adicionalmente ataja error de tabla con
     * hijos o genera exception cuando sea otro.
     * @param int $id
     * @param string $resource
     * @param string $child
     * @return bool|\PCI\Models\User
     */
    protected function executeDelete($id, $resource = 'Recurso', $child = 'Recursos')
    {
        $model = $this->getById($id);

        return $this->deleteDestroyPrototype($model, $resource, $child, 'delete');
    }

    /**
     * Busca un modelo solo por el Id que posea.
     * @param  string|int $id
     * @return \PCI\Models\AbstractBaseModel
     */
    public function getById($id)
    {
        $this->checkId($id);

        return $this->model->findOrFail($id);
    }

    /**
     * Ejecuta un delete en la base de datos por medio de Eloquent.
     * Cuando se ejecuta el delete tambien genera el flash
     * de sesion relacion a la actividad por medio de
     * los parametros establecidos de recurso e hijo
     * junto al metodo (tal vez borrar parametro).
     * @param \PCI\Models\AbstractBaseModel $model
     * @param string $resource El nombre del recurso en texto legible.
     * @param string $child El nombre del recurso hijo en texto legible.
     * @param string $method el tipo de metodo a ejecutar (delete|forceDelete)
     * @return bool|\PCI\Models\User bool si pudo eliminar o \PCI\Models\User
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function deleteDestroyPrototype(AbstractBaseModel $model, $resource, $child, $method)
    {
        try {
            $model->$method();
        } catch (Exception $e) {
            // si la excepcion es una instancia de QueryException es muy probable
            // que sea por algun error en cuanto a la relacion,
            // es decir, por violacion de integridad.
            if ($e instanceof QueryException || $e->getCode() == 23000) {
                flash()->error("No deben haber {$child} asociados.");

                return $model;
            }

            // si no es una instancia de QueryException,
            // entonces hay problemas inesperados.
            throw new HttpException(500, "No se pudo eliminar al {$resource}, error inesperado.", $e);
        }

        flash()->success("El {$resource} ha sido eliminado correctamente.");

        return true;
    }

    /**
     * Genera un objeto LengthAwarePaginator con una coleccion paginada.
     * @link http://stackoverflow.com/a/29527744
     * @param \Illuminate\Database\Eloquent\Collection $results la coleccion de modelos.
     * @param int $quantity la cantidad por pagina a mostrar en la vista.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function generatePaginator(Collection $results, $quantity = 25)
    {
        // este es la variable del que depende el Paginator
        // para saber en que pagina esta en el conjunto.
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
        $collection = collect();

        // para generar los datos necesarios necesitamos que
        // la data sea manipulada y convertida en
        // una coleccion con datos especificos.
        $results->each(function ($model) use (&$collection) {
            $data = $this->makePaginatorData($model);

            $collection->push($data);
        });

        return $collection;
    }

    /**
     * Genera la data necesaria que utilizara el paginator,
     * contiene los datos relevantes para la tabla, esta
     * informacion debe ser un array asociativo.
     * Como cada repositorio contiene modelos con
     * estructuras diferentes, necesitamos
     * manener este metodo abstracto.
     * @param \PCI\Models\AbstractBaseModel $model
     * @return array<string, string> En donde el key es el titulo legible del campo.
     */
    abstract protected function makePaginatorData(AbstractBaseModel $model);
}
