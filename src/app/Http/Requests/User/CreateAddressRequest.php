<?php namespace PCI\Http\Requests\User;

use PCI\Http\Requests\Request;
use PCI\Repositories\Interfaces\User\AddressRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $address  = $this->addrRepo->find($this->route('addresses'));
                $employee = $address->employee;

                return $this->user()->can('create', [$address, $employee]);
                break;

            case 'POST':
                $employee = $this->addrRepo->findParent($this->route('employees'));

                $address = $this->addrRepo->newInstance();

                return $this->user()->can('create', [$address, $employee]);

            default:
                throw new HttpException(500, 'Request con metodo invalido.');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'parish_id' => 'required|numeric',
            'building'  => 'alpha|between:3, 50',
            'street'    => 'alpha|max:255',
            'av'        => 'alpha|max:255',
        ];
    }
}
