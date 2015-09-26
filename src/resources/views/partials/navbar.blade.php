{!!

Navbar::withBrand(trans('defaults.appName'), route('index'))
    ->withContent(Navigation::links($links))
    ->withContent($searchBox)
    ->withContent(Navigation::links($rightLinks)->right())
    ->fluid()

!!}
