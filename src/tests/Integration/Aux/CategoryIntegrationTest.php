<?php namespace Tests\Integration\Aux;

use PCI\Models\Category;
use PCI\Models\User;
use Tests\Integration\AbstractIntegrationTest;

class CategoryIntegrationTest extends AbstractIntegrationTest
{

    public function testCats()
    {
        $user = factory(User::class)->create([
            'confirmation_code' => null,
            'profile_id' => User::ADMIN_ID
        ]);

        $this->actingAs($user)->visit('categorias')->see('No hay información que mostrar.');

        $cat = factory(Category::class)->create();

        $this->actingAs($user)->visit('categorias')->see($cat->desc);
    }
}
