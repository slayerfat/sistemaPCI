<?php namespace PCI\Http\Requests\User;

use PCI\Http\Requests\Request;
use PCI\Repositories\Interfaces\User\AddressRepositoryInterface;

class CreateAddressRequest extends Request
{

    /**
     * @var \PCI\Repositories\Interfaces\User\AddressRepositoryInterface
     */
    private $addrRepo;

    /**
     * @param \PCI\Repositories\Interfaces\User\AddressRepositoryInterface $addrRepo
     */
    public function __construct(AddressRepositoryInterface $addrRepo)
    {
        $this->addrRepo = $addrRepo;
    }

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        $employee = $this->addrRepo->findParent($this->route('employees'));

        $address = $this->addrRepo->newInstance();

        return $this->user()->can('create', [$address, $employee]);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
