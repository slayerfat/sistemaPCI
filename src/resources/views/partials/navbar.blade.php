{!!

Navbar::withBrand('sistemaPCI', '/')
    ->withContent(Navigation::links($links))
    ->withContent($searchBox)
    ->withContent(Navigation::links($rightLinks)->right())

!!}
