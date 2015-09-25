<?php namespace PCI\Http\Requests\User;

use PCI\Http\Requests\Request;
use PCI\Repositories\Interfaces\User\AddressRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CreateAddressRequest
 * @package PCI\Http\Requests\User
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class CreateAddressRequest extends Request
{

    /**
     * La implementacion del repositorio.
     * @var \PCI\Repositories\Interfaces\User\AddressRepositoryInterface
     */
    private $addrRepo;

    /**
     * Genera la instancia de esta peticion.
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
        // se chequea el tipo de metodo de la peticion.
        switch ($this->method()) {
            // este caso esta actualizando, asi que
            // buscamos a la direcicon a actualizar
            case 'PUT':
            case 'PATCH':
                $address  = $this->addrRepo->find($this->route('addresses'));
                $employee = $address->employee;

                return $this->user()->can('create', [$address, $employee]);

            // en este caso necesitamos al padre y una nueva
            // instancia de direccion para chequear la poliza.
            case 'POST':
                $employee = $this->addrRepo->findParent($this->route('employees'));

                $address = $this->addrRepo->newInstance();

                return $this->user()->can('create', [$address, $employee]);

            // si no son esos metodos, etonces probable que la peticion es invalida.
            default:
                throw new HttpException(500, 'Request con metodo invalido.');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, string>
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
