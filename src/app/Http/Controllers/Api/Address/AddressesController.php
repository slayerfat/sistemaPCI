<?php namespace PCI\Http\Controllers\Api\Address;

use Illuminate\Database\Eloquent\Collection;
use PCI\Http\Controllers\Controller;
use PCI\Models\Parish;
use PCI\Models\State;
use PCI\Models\Town;

class AddressesController extends Controller
{

    /**
     * Regresa todos los estados.
     * @return Collection
     */
    public function states()
    {
        return State::all();
    }

    /**
     * Regresa los municipios del estado tal ($id).
     * @param int $id el id del estado tal
     * @return Collection
     */
    public function towns($id)
    {
        return Town::whereStateId($id)->get();
    }

    /**
     * Regresa todos los municipios que tengan
     * el mismo estado del municipio tal ($id)
     * @param int $id el id del municipio tal
     * @return Collection
     */
    public function town($id)
    {
        $stateId = Town::whereId($id)->firstOrFail()->state_id;

        return Town::whereStateId($stateId)->get();
    }

    /**
     * Regresa las parroquias del municipio tal ($id)
     * @param int $id el id de la municipio tal
     * @return Collection
     */
    public function parishes($id)
    {
        return Parish::whereTownId($id)->get();
    }

    /**
     * Regresa todas las parroquias que tengan
     * el mismo municipio de la parroquia tal ($id)
     * @param int $id el id de la parroquia tal
     * @return Collection
     */
    public function parish($id)
    {
        $townId = Parish::whereId($id)->firstOrFail()->town_id;

        return Parish::whereTownId($townId)->get();
    }
}
