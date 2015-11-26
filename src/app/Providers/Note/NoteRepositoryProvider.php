<?php namespace PCI\Providers\Note;

use Illuminate\Support\ServiceProvider;
use PCI\Models\Note;
use PCI\Repositories\Interfaces\Aux\NoteTypeRepositoryInterface;
use PCI\Repositories\Interfaces\Note\NoteRepositoryInterface;
use PCI\Repositories\Note\NoteRepository;

/**
 * Class PetitionRepositoryProvider
 *
 * @package PCI\Providers\User
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteRepositoryProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NoteRepositoryInterface::class, function ($app) {
            return new NoteRepository(
                $app[Note::class],
                $app[NoteTypeRepositoryInterface::class]
            );
        });
    }
}
