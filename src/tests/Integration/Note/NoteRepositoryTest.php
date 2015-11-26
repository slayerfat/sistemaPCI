<?php namespace Tests\Integration\Note;

/**
 * Por ahora extendemos AbstractUserIntegration,
 * porque no tenemos la necesidad en este momento de
 * crear otra clase especifica para Items y sus pruebas.
 * Considerando cambiar nombre de la clase de
 * AbstractUserIntegration -> AbstractGeneralIntegration o algo similar.
 */

use PCI\Models\Note;
use PCI\Models\User;
use Tests\Integration\User\AbstractUserIntegration;

/**
 * Class NoteRepositoryTest
 *
 * @package Tests\Integration\Note
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class NoteRepositoryTest extends AbstractUserIntegration
{

    /**
     * @var Note[]|\Illuminate\Support\Collection
     */
    public $notes;

    /**
     * @var \PCI\Models\User
     */
    public $randomUser;

    public function testIndexReturnsCorrectAmountIfAdmin()
    {
        foreach (range(1, 5) as $index) {
            $this->notes[] = factory(Note::class)
                ->create(['comments' => "mocked_[$index]"]);
        }

        foreach ($this->notes as $note) {
            $this->actingAs($this->user)
                ->visit(route('notes.index'))
                ->seeLink($note->user->name, route('users.show', $note->user->name, $note->user->name));
        }
    }

    public function testIndexReturnsCeroNotesIfNotAdmin()
    {
        foreach (range(1, 5) as $index) {
            $this->notes[] = factory(Note::class)
                ->create(['comments' => "mocked_[$index]"]);
        }

        foreach ($this->notes as $note) {
            $this->actingAs($this->randomUser)
                ->visit(route('notes.index'))
                ->dontSee($note->user->email);
        }
    }

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        return $this->getGenericAdmin();
    }

    /**
     * @return void
     */
    protected function persistData()
    {
        $this->randomUser = factory(User::class, 'user')->create();
    }
}
