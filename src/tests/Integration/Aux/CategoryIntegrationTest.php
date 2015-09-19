<?php namespace Tests\Integration\Aux;

class CategoryIntegrationTest extends AbstractAuxTest
{

    public function testTodoNewRequirements()
    {
        $this->visit('categorias')
            ->assertResponseOk();
    }
}
