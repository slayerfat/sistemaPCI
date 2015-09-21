<?php namespace PCI\Http\Controllers\Aux;

use PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface;
use Redirect;
use Illuminate\View\Factory;
use PCI\Http\Requests\Aux\MakerRequest;

class MakersController extends AbstractAuxController
{

    /**
     * @var \PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface
     */
    private $repo;

    /**
     * @var \PCI\Models\Maker
     */
    private $model;

    /**
     * @param \Illuminate\View\Factory $view
     * @param \PCI\Repositories\Interfaces\Aux\MakerRepositoryInterface $repo
     */
    public function __construct(Factory $view, MakerRepositoryInterface $repo)
    {
        parent::__construct($view);

        $this->repo = $repo;
    }

    public function index()
    {
        return $this->makeView(
            'aux.index',
            $this->repo->getIndexViewVariables()
        );
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $variables = $this->repo->getShowViewVariables($id);

        $variables->setUsersGoal('Fabricantes en el sistema');

        return $this->makeView('aux.show', $variables);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Como estas actividades son genericas para las entidades auxiliares
        // se decide generar este metodo para disminuir la duplicacion
        // que tendria si en dado caso, se hubiera hecho normal.
        $results = $this->repo->getCreateViewVariables();

        return $this->makeView('aux.create', $results);
    }

    /**
     * @param \PCI\Http\Requests\Aux\MakerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MakerRequest $request)
    {
        $this->model = $this->repo->create($request->all());

        return Redirect::route('makers.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $variables = $this->repo->getEditViewVariables($id);

        $variables->setUsersGoal(trans('models.makers.edit'));

        return $this->makeView('aux.edit', $variables);
    }

    /**
     * @param $id
     * @param \PCI\Http\Requests\Aux\MakerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, MakerRequest $request)
    {
        $this->model = $this->repo->update($id, $request->all());

        return Redirect::route('makers.show', $this->model->slug);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->model = $this->repo->delete($id);

        if ($this->model === true) {
            return Redirect::route('makers.index');
        }

        return Redirect::route('makers.show', $this->model->desc);
    }
}
