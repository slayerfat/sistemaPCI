<?php namespace PCI\Repositories\User;

use Gate;
use Illuminate\Support\Collection;
use PCI\Mamarrachismo\Collection\ItemCollection;
use PCI\Mamarrachismo\Converter\interfaces\StockTypeConverterInterface;
use PCI\Models\AbstractBaseModel;
use PCI\Models\Petition;
use PCI\Repositories\AbstractRepository;
use PCI\Repositories\Interfaces\Aux\PetitionTypeRepositoryInterface;
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
     * @var \PCI\Repositories\Interfaces\Aux\PetitionTypeRepositoryInterface
     */
    private $typeRepo;

    /**
     * Genera una nueva instancia de este repositorio
     *
     * @param \PCI\Models\AbstractBaseModel   $model
     * @param ItemRepositoryInterface         $itemRepo
     * @param StockTypeConverterInterface     $converter
     * @param PetitionTypeRepositoryInterface $typeRepo
     */
    public function __construct(
        AbstractBaseModel $model,
        ItemRepositoryInterface $itemRepo,
        StockTypeConverterInterface $converter,
        PetitionTypeRepositoryInterface $typeRepo
    ) {
        parent::__construct($model);

        $this->itemRepo  = $itemRepo;
        $this->converter = $converter;
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
        $results = $this->getAll()->load('type', 'user')->sortByDesc('updated_at');

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

        $items = $this->checkItems($data['itemCollection'], $petition);

        // asociamos la peticion al usuario en linea.
        $this->getCurrentUser()->petitions()->save($petition);

        return $this->attachItems($items, $petition);
    }

    /**
     * Chequea que los items solicitados sean adecuados.
     *
     * @param ItemCollection       $items el request con el id del item,
     *                                    cantidad y tipo de stock.
     * @param \PCI\Models\Petition $petition
     * @return ItemCollection los items actualizados.
     */
    private function checkItems(ItemCollection $items, Petition &$petition)
    {
        // por cada item dentro de los items, lo asociamos
        // con el modelo en la base de datos.
        foreach ($items as $id => $array) {
            /** @var \PCI\Models\Item $item */
            $item = $this->itemRepo->getById($id);
            $this->converter->setItem($item);

            foreach ($array as $data) {
                // debemos chequear que los items tengan
                // los tipos y cantidades correctos.
                if (Gate::denies('addItem', [
                    $petition,
                    $this->converter,
                    $data['amount'],
                    $data['stock_type_id'],
                ])
                ) {
                    $petition->comments .= sizeof($petition->comments) <= 1 ? "" : "\r\n";

                    $petition->comments .= "El usuario {$this->getCurrentUser()->name} "
                        . "solicito {$data['amount']} ({$data['amount']}:{$data['stock_type_id']}) "
                        . "y existe un stock de {$item->formattedStock()} "
                        . "({$item->stock()}:{$item->stock_type_id}) "
                        . "disponibles del Item {$item->desc}\r\n";

                    $items->remove($id);

                    continue;
                }
            }
        }

        return $items;
    }

    /**
     * @param ItemCollection       $items
     * @param \PCI\Models\Petition $petition
     * @return \PCI\Models\Petition
     */
    protected function attachItems(ItemCollection $items, Petition $petition)
    {
        // si no hay items que incluir por alguna
        // razon, entonces rechazamos el pedido.
        if ($items->count() < 1) {
            $petition->status = false;
            $petition->save();

            return $petition;
        }

        // Añade los items solicitados y sus cantidades a la
        // tabla correspondiente en la base de datos.
        foreach ($items as $id => $array) {
            foreach ($array as $data) {
                $petition->items()->attach($id, [
                    'quantity'      => $data['amount'],
                    'stock_type_id' => $data['stock_type_id'],
                ]);
            }
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

        $items = $this->checkItems($data['itemCollection'], $petition);

        // como posiblemente los items cambiaron, entonces
        // limpiamos la tabla para re-añadir los items.
        $petition->items()->sync([]);

        return $this->attachItems($items, $petition);
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
        /** @var \PCI\Models\Petition $petition */
        $petition = $this->find($id)->load('items');

        if (is_null($petition->status)) {
            if (!$petition->items->isEmpty()) {
                $petition->items()->sync([]);
            }

            return $this->executeDelete(
                $id,
                trans('models.petitions.plural'),
                trans('models.items.plural')
            );
        }

        return $petition;
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
                'id'                 => $item->id,
                'desc'               => $item->desc,
                'stock'              => $item->formattedStock(),
                'percentageStock'    => $item->percentageStock(),
                'formattedReserved'  => $item->formattedReserved(),
                'percentageReserved' => $item->percentageReserved(),
                'due'                => $item->type->perishable,
                'quantity'           => $item->pivot->quantity,
                'stock_type_id'      => $item->pivot->stock_type_id,
                'type'               => $item->type,
            ]);
        });

        return $results;
    }

    /**
     * Regresa una coleccion de pedidos sin notas asociadas
     * o con notas rechazadas o por aprobar.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findWithoutNotes()
    {
        $petitions = $this->getAll()->load('notes');
        http://laravel.com/docs/5.1/collections#method-reject
        return $petitions->reject(function (Petition $petition) {
            $status = true;
            // nos interesa saber si existen notas
            // que esten rechazadas o por aprobar
            foreach ($petition->notes as $note) {
                if ($note->status == true) {
                    $status = false;
                }
            }

            if ($petition->notes->isEmpty() || $status) {
                // solo nos interesan los pedidos que hayan
                // sido aprobados y que tengan items.
                return !($petition->status && $petition->itemCount > 0);
            }

            return true;
        });
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
     * @param \PCI\Models\AbstractBaseModel|\PCI\Models\Petition $model
     * @return array<string, string> En donde el key es el titulo legible del
     *                       campo.
     */
    protected function makePaginatorData(AbstractBaseModel $model)
    {
        return [
            'uid'                => $model->id,
            'Numero'             => $model->id,
            'Usuario'            => link_to_route('users.show', $model->user->name, $model->user->name),
            'Tipo'               => link_to_route('petitionTypes.show', $model->type->desc, $model->type->slug),
            'Fecha de solicitud' => $model->created_at->diffForHumans(),
            'Status'             => $model->formattedStatus,
        ];
    }
}
