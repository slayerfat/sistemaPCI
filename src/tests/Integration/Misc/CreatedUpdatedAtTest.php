<?php namespace Tests\Integration\Misc;

/**
 * Por ahora extendemos AbstractUserIntegration,
 * porque no tenemos la necesidad en este momento de
 * crear otra clase especifica para Items y sus pruebas.
 * Considerando cambiar nombre de la clase de
 * AbstractUserIntegration -> AbstractGeneralIntegration o algo similar.
 */

use PCI\Models\Gender;
use PCI\Models\User;
use Tests\Integration\User\AbstractUserIntegration;

class CreatedUpdatedAtTest extends AbstractUserIntegration
{

    public function testModelShouldHaveEqualDates()
    {
        $gender       = new Gender();
        $gender->desc = 'xyz';
        $gender->save();
        $createdAt = $gender->created_at;
        $updatedAt = $gender->updated_at;

        $this->assertEquals(0, $createdAt->diffInSeconds($updatedAt));
    }

    public function testModelShouldHaveValidUpdatedAtDates()
    {
        $gender       = Gender::find(1);
        $gender->desc = 'abc';
        $gender->save();

        $createdAt = Gender::find(1)->created_at;
        $updatedAt = Gender::find(1)->updated_at;

        $this->actingAs($this->user)
            ->visit(route('genders.show', $gender->id))
            ->see($createdAt->diffForHumans())
            ->see($updatedAt->diffForHumans());

        $this->assertNotEquals(0, $createdAt->diffInSeconds($updatedAt));
    }

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        return factory(User::class, 'admin')->create();
    }

    /**
     * @return void
     */
    protected function persistData()
    {
        factory(Gender::class)->create([
            'created_at' => '1999-09-09',
            'updated_at' => '1999-09-09',
        ]);
    }
}
