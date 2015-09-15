{!!

Navbar::withBrand(trans('defaults.appName'), '/')
    ->withContent(Navigation::links($links))
    ->withContent($searchBox)
    ->withContent(Navigation::links($rightLinks)->right())

!!}
