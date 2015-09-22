<?php namespace Tests\Integration\Aux;

class CategoryIntegrationTest extends AbstractAuxIntegration
{

    public function testTodoNewRequirements()
    {
        $this->visit('categorias')
            ->assertResponseOk();
    }
}
