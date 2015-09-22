<?php namespace PCI\Http\Controllers\User;

use Flash;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use PCI\Http\Controllers\Controller;
use PCI\Http\Requests;
use PCI\Http\Requests\User\CreateAddressRequest;
use PCI\Repositories\Interfaces\User\AddressRepositoryInterface;
use Redirect;
use View;

class AddressesController extends Controller
{

    /**
     * @var \PCI\Repositories\Interfaces\User\AddressRepositoryInterface
     */
    private $addrRepo;

    /**
     * @var \PCI\Models\User
     */
    private $user;

    /**
     * @param \PCI\Repositories\Interfaces\User\AddressRepositoryInterface $addrRepo
     * @param \Illuminate\Auth\Guard $auth
     */
    public function __construct(
        AddressRepositoryInterface $addrRepo,
        Guard $auth
    ) {
        $this->addrRepo = $addrRepo;

        $this->user = $auth->user();
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $employee = $this->addrRepo->findParent($id);
        $address  = $this->addrRepo->newInstance();

        // En Garde!!
        if ($this->user->cant('create', [$address, $employee])) {
            return $this->redirectBack();
        }

        return View::make('addresses.create', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     * @param int $id
     * @param \PCI\Http\Requests\User\CreateAddressRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, CreateAddressRequest $request)
    {
        $data = $request->all();

        // solucion mamarracha, pero asi nos
        // ahorramos modificar la interface
        $data['employee_id'] = $id;

        /** @var \PCI\Models\User $user */
        $user = $this->addrRepo->create($data);

        Flash::success(trans('models.addresses.store.success'));

        return Redirect::route('users.show', $user->name);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = $this->addrRepo->find($id);

        return View::make('addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->addrRepo->update($id, $request->all());

        Flash::success(trans('models.addresses.update.success'));

        return Redirect::route('users.show', $user->name);
    }
}
