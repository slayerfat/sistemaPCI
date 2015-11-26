<?php namespace PCI\Http\Controllers;

use PCI\Models\Note;
use PCI\Models\Petition;

/**
 * Class IndexController
 *
 * @package PCI\Http\Controllers
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class IndexController extends Controller
{

    /**
     * Regresa la pagina principal del sistema.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $petitions = Petition::latest()->take(5);
        $notes     = Note::latest()->take(5)->get();

        return view('index', compact('petitions', 'notes'));
    }

    /**
     * Regresa la pagina principal pero de
     * un usuario todavia no verificado.
     *
     * @return \Illuminate\View\View
     */
    public function unverified()
    {
        $user = auth()->user();

        return view('unverified', compact('user'));
    }
}
