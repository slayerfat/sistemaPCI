<?php namespace PCI\Http\ViewComposers;

use Illuminate\View\View;
use PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface;

/**
 * Class UserShowViewComposer
 * @package PCI\Http\ViewComposers
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class UserShowViewComposer
{

    /**
     * La implementacion de el parseador de telefono.
     * @var \PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface
     */
    private $phoneParser;

    /**
     * Genera una isntancia de este view composer con el parseador necesario.
     * @param \PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface $phoneParser
     */
    public function __construct(PhoneParserInterface $phoneParser)
    {
        $this->phoneParser = $phoneParser;
    }

    /**
     * Genera la vista dandole el parseador para poder
     * generar telefonos en formato legible.
     * @param \Illuminate\View\View $view
     */
    public function compose(View $view)
    {
        $phoneParser = $this->phoneParser;

        $view->with(compact('phoneParser'));
    }
}
