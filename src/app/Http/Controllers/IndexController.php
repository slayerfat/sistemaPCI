<?php namespace PCI\Http\Controllers;

/**
 * Class IndexController
 * @package PCI\Http\Controllers
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class IndexController extends Controller
{
    /**
     * Regresa la pagina principal del sistema.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Regresa la pagina principal pero de
     * un usuario todavia no verificado.
     * @return \Illuminate\View\View
     */
    public function unverified()
    {
        $user = auth()->user();

        return view('unverified', compact('user'));
    }
}
