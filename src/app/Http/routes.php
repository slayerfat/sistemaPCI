<?php

// sanity-check
Route::get('/status', ['as' => 'status', function () {
    $x    = rand(7, 730);
    $days = '-' . $x . ' days';

    $date = Date::now()->timespan($days);

    return view('status', compact('date'));
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
$routes->push(new \PCI\Http\Routes\AddressRoutes);
$routes->push(new \PCI\Http\Routes\MiscRoutes);
$routes->push(new \PCI\Http\Routes\UserRoutes);
$routes->push(new \PCI\Http\Routes\AuxRoutes);

foreach ($routes as $route) {
    $route->execute();
}
