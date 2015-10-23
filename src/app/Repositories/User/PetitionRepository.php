<?php namespace PCI\Repositories\User;

use Carbon\Carbon;
use Gate;
use Illuminate\Support\Collection;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\AbstractBaseModel;
use PCI\Models\Petition;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\Item\ItemRepositoryInterface;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;
use PCI\Repositories\Traits\CanChangeStatus;
use PCI\Repositories\ViewVariable\ViewPaginatorVariable;

/**
 * Class PetitionRepository
 *
 * @package PCI\Repositories\User
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionRepository extends AbstractRepository implements PetitionRepositoryInterface
{

    use CanChangeStatus;

    /**
     * En esta caso es una peticion
     *
     * @var \PCI\Models\Petition
     */
    protected $model;

    /**
     * La implementacion del repositorio de items
     *
     * @var \PCI\Repositories\Interfaces\Item\ItemRepositoryInterface
     */
    private $itemRepo;

    /**
     * La implementacion que se encarga de chequear y convertir el tipo de stock
     * para los movimientos que se persisten en este repo.
     *
     * @var \PCI\Mamarrachismo\Converter\StockTypeConverter
     */
    private $converter;

    /**
     * Genera una nueva instancia de este repositorio
     *
     * @param \PCI\Models\AbstractBaseModel                             $model
     * @param \PCI\Repositories\Interfaces\Item\ItemRepositoryInterface $itemRepo
     * @param StockTypeConverterInterface                               $converter
     */
    public function __construct(
        AbstractBaseModel $model,
        ItemRepositoryInterface $itemRepo,
        StockTypeConverterInterface $converter
    ) {
        parent::__construct($model);

        $this->itemRepo  = $itemRepo;
        $this->converter = $converter;
    }

    /**
     * Regresa variable con una coleccion y datos
     * adicionales necesarios para generar la vista.
     *
     * @return \PCI\Repositories\ViewVariable\ViewPaginatorVariable
     */
    public function getIndexViewVariables()
    {
        return new ViewPaginatorVariable($this->getTablePaginator(), 'petitions');
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
        $results = $this->getAll()->load('type', 'user');

        return $this->generatePaginator($results, $quantity);
    }

    /**
     * Consigue todos los elementos y devuelve una coleccion.
     *
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

        return $this->findByUserId($user->id);
    }

    /**
     * Busca las peticiones segun el Id de algun usuario.
     *
     * @param string|int $id del usuario.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByUserId($id)
    {
        return $this->model->whereUserId($id)->get();
    }

    /**
     * Persiste informacion referente a una entidad.
     *
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

        $items = $this->checkItems($data['items'], $petition);

        // asociamos la peticion al usuario en linea.
        $this->getCurrentUser()->petitions()->save($petition);

        return $this->attachItems($items, $petition);
    }

    /**
     * Chequea que los items solicitados sean adecuados.
     *
     * @param array                $items el request con el id del item,
     *                                    cantidad y tipo de stock.
     * @param \PCI\Models\Petition $petition
     * @return array los items actualizados.
     */
    private function checkItems(array $items, Petition &$petition)
    {
        // por cada item dentro de los items, lo asociamos
        // con el modelo en la base de datos.
        foreach ($items as $id => $data) {
            /** @var \PCI\Models\Item $item */
            $item = $this->itemRepo->getById($id);
            $this->converter->setItem($item);

            // debemos chequear que los items tengan
            // los tipos y cantidades correctos.
            if (Gate::denies('addItem', [
                $petition,
                $this->converter,
                $data['amount'],
                $data['type'],
            ])
            ) {
                $petition->comments .= sizeof($petition->comments) <= 1 ? "" : "\r\n";

                $petition->comments .= "El usuario {$this->getCurrentUser()->name} "
                    . "solicito {$data['amount']} ({$data['amount']}:{$data['type']}) "
                    . "y existe un stock de {$item->formattedStock()} "
                    . "({$item->stock}:{$item->stock_type_id}) "
                    . "disponibles del Item {$item->desc}\r\n";

                unset($items[$id]);

                continue;
            }
        }

        return $items;
    }

    /**
     * @param array                $items
     * @param \PCI\Models\Petition $petition
     * @return \PCI\Models\Petition
     */
    protected function attachItems(array $items, Petition $petition)
    {
        // si no hay items que incluir por alguna
        // razon, entonces rechazamos el pedido.
        if (count($items) < 1) {
            $petition->status = false;
            $petition->save();

            return $petition;
        }

        // Añade los items solicitados y sus cantidades a la
        // tabla correspondiente en la base de datos.
        foreach ($items as $id => $data) {
            $petition->items()->attach($id, [
                'quantity'      => $data['amount'],
                'stock_type_id' => $data['type'],
            ]);
        }

        return $petition;
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
        $petition = $this->find($id);

        // esta informacion no nos interesa al
        // momento de crear los items asociados.
        $petition->comments         = $data['comments'];
        $petition->petition_type_id = $data['petition_type_id'];
        $petition->request_date     = Carbon::now();

        $items = $this->checkItems($data['items'], $petition);

        // como posiblemente los items cambiaron, entonces
        // limpiamos la tabla para re-añadir los items.
        $petition->items()->sync([]);

        // Añade los items solicitados y sus cantidades a la
        // tabla correspondiente en la base de datos.
        foreach ($items as $id => $data) {
            $petition->items()->attach($id, [
                'quantity'      => $data['amount'],
                'stock_type_id' => $data['type'],
            ]);
        }

        $petition->save();

        return $petition;
    }

    /**
     * Busca algun Elemento segun Id u otra regla.
     *
     * @param  string|int $id El identificador unico (slug|name|etc|id).
     * @return \PCI\Models\AbstractBaseModel|\PCI\Models\Petition
     */
    public function find($id)
    {
        return $this->getById($id)->load('items', 'user');
    }

    /**
     * Elimina del sistema un modelo.
     *
     * @param int $id El identificador unico.
     * @return boolean|\PCI\Models\AbstractBaseModel
     */
    public function delete($id)
    {
        return $this->executeDelete($id, trans('models.petitions.plural'), trans('models.items.plural'));
    }

    /**
     * Genera una coleccion de items relacionados
     * con el pedido en formato para HTML.
     *
     * @param \Illuminate\Support\Collection $items
     * @return \Illuminate\Support\Collection
     */
    public function getItemsCollection(Collection $items)
    {
        $results = collect();

        $items->each(function ($item) use (&$results) {
            /** @var \PCI\Models\Item $item */
            $results->push([
                'id'            => $item->id,
                'desc'          => $item->desc,
                'stock'         => $item->formattedStock(),
                'quantity'      => $item->pivot->quantity,
                'stock_type_id' => $item->pivot->stock_type_id,
            ]);
        });

        return $results;
    }

    /**
     * Regresa una coleccion de pedidos sin notas asociadas.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findWithoutNotes()
    {
        // http://laravel.com/docs/5.1/collections#method-reject
        return $this->getAll()->reject(function ($petition) {
            if ($petition->notes->isEmpty()) {
                // solo nos interesan los pedidos que hayan
                // sido aprobados y que tengan items.
                return !($petition->status && $petition->itemCount > 0);
            }

            return true;
        });
    }

    /**
     * Genera la data necesaria que utilizara el paginator,
     * contiene los datos relevantes para la tabla, esta
     * informacion debe ser un array asociativo.
     * Como cada repositorio contiene modelos con
     * estructuras diferentes, necesitamos
     * manener este metodo abstracto.
     *
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\Petition $model
     * @return array<string, string> En donde el key es el titulo legible del
     *                       campo.
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
            'Status'             => $model->formattedStatus,
        ];
    }
}
