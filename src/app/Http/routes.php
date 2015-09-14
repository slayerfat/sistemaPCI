<?php

// sanity-check
Route::get('/status', ['as' => 'status', function () {
    return view('status');
}]);

Route::get('/home', ['as' => 'home', function () {
    return redirect()->route('index');
}]);

/**
 * @todo ver como mover esto a un ServiceProvider o algo similar.
 *
 * @see http://i62.tinypic.com/8wjf2u.jpg - MFW
 * COPYPASTA de https://github.com/slayerfat/orbiagro.com.ve/blob/master/app/Http/routes.php
 */

$routes = collect();

// El orden importa.
$routes->push(new \PCI\Http\Routes\MiscRoutes);

foreach ($routes as $route) {
    $route->execute();
}
