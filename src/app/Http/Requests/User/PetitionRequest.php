<?php namespace PCI\Http\Requests\User;

use Gate;
use PCI\Http\Requests\Request;
use PCI\Http\Requests\Traits\SanitizeItemsRequestTrait;
use PCI\Models\Petition;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;

/**
 * Class PetitionRequest
 *
 * @package PCI\Http\Requests\User
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionRequest extends Request
{

    use SanitizeItemsRequestTrait;

    /**
     * @var \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface
     */
    private $repo;

    /**
     * PetitionRequest constructor.
     *
     * @param \PCI\Repositories\Interfaces\User\PetitionRepositoryInterface $repo
     */
    public function __construct(PetitionRepositoryInterface $repo)
    {
        parent::__construct();

        $this->repo = $repo;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->isMethod('POST')) {
            return Gate::allows('create', new Petition);
        }

        return Gate::allows('update', $this->repo->find($this->route('petitions')));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'comments'         => 'string|between:5,255',
            'petition_type_id' => 'numeric|exists:petition_types,id',
        ];

        $this->checkItems($rules);

        return $rules;
    }

    /**
     * regresa un array con los campos necesarios para la coleccion.
     *
     * @return array
     */
    protected function itemCollectionRules()
    {
        return [
            'item_id',
            'stock_type_id',
            'amount',
        ];
    }
}
