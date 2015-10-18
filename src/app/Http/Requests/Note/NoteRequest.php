<?php namespace PCI\Http\Requests\Note;

use Gate;
use PCI\Http\Requests\Request;
use PCI\Http\Requests\Traits\SanitizeItemsRequestTrait;
use PCI\Models\Note;
use PCI\Repositories\Interfaces\User\PetitionRepositoryInterface;

/**
 * Class NoteRequest
 *
 * @package PCI\Http\Requests\User
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteRequest extends Request
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
            return Gate::allows('create', [new Note, $this->repo]);
        }

        return Gate::allows('update', [
            $this->repo->find($this->route('notes')),
            $this->repo,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ajustamos el request
        $this->sanitizeRequest();

        $rules = [
            'comments'     => 'string|between:5,255',
            'note_type_id' => 'numeric|exists:petition_types,id',
        ];

        $this->checkItems($rules);

        return $rules;
    }
}
