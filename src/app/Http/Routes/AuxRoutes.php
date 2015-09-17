<?php namespace PCI\Http\Routes;

class AuxRoutes extends PCIRoutes
{

    /**
     * @var array
     */
    protected $restfulOptions = [];

    /**
     * @var array
     */
    protected $nonRestfulOptions = [];

    /**
     * Genera todas las rutas relacionadas con esta clase
     *
     * @return void
     */
    public function execute()
    {
        $this->executePrototype(
            $this->restfulOptions,
            $this->nonRestfulOptions
        );
    }
}
