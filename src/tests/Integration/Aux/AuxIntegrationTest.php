<?php namespace Tests\Integration\Aux;

use PCI\Models\Category;
use PCI\Models\Department;

class AuxIntegrationTest extends AbstractAuxTest
{

    public function setUp()
    {
        parent::setUp();

        // como estas entidades son tan genericas, solo se necesita
        // saber el nombre en la ruta ($model[0]), el alias
        // ($model[1]) y la clase para crear nuevos
        // registros y objetos ($model[2])
        $modelData = [
            ['categorias', 'cats', Category::class],
            ['departamentos', 'depts', Department::class],
        ];

        foreach ($modelData as $model) {
            $this->setData($model[0], $model[1], $model[2]);
        }
    }

    public function testAuxIndexShouldHaveTableWithValidInfo()
    {
        foreach ($this->data as $data) {
            $this->actingAs($this->user)
                ->visit($data->index)
                ->see('No hay información que mostrar.');

            $cat = factory($data->class)->create();

            $this->actingAs($this->user)
                ->visit($data->index)
                ->see($cat->desc);
        }
    }

    public function testUserShouldSeeCreateAuxOptions()
    {
        foreach ($this->data as $data) {
            $this->actingAs($this->user)
                ->visit('/')
                ->see(trans("aux.{$data->alias}.create"));
        }
    }

    public function testCreateAuxShouldReturnAForm()
    {
        foreach ($this->data as $data) {
            $this->actingAs($this->user)
                ->visit('/')
                ->click(trans("aux.{$data->alias}.create"))
                ->seePageIs($data->create);
        }
    }
}
