<?php namespace PCI\Http\Controllers;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }
}
