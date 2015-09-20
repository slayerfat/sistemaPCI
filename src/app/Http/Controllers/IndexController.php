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

    /**
     * @return \Illuminate\View\View
     */
    public function unverified()
    {
        $user = auth()->user();

        return view('unverified', compact('user'));
    }
}
