<?php namespace PCI\Http\ViewComposers;

use Illuminate\View\View;
use PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface;

class UserShowViewComposer
{

    /**
     * @var \PCI\Mamarrachismo\PhoneParser\Interfaces\PhoneParserInterface
     */
    private $phoneParser;

    public function __construct(PhoneParserInterface $phoneParser)
    {
        $this->phoneParser = $phoneParser;
    }

    public function compose(View $view)
    {
        $phoneParser = $this->phoneParser;

        $view->with(compact('phoneParser'));
    }
}
