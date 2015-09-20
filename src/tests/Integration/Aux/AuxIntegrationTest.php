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

    public function testCreatingAuxShouldReturnAShowView()
    {
        foreach ($this->data as $data) {
            $this->actingAs($this->user)
                ->visit($data->create)
                ->type('testing', 'desc')
                ->press(trans("aux.{$data->alias}.create"))
                ->seePageIs($data->show . 'testing');
        }
    }

    public function testEditAuxShouldReturnAForm()
    {
        foreach ($this->data as $data) {
            $model = factory($data->class)->create(['desc' => 'testing']);

            $this->actingAs($this->user)
                ->visit($data->show . $model->desc)
                ->click('Editar')
                ->seePageIs($data->edit . $model->id . '/editar');
        }
    }

    public function testEditingAuxShouldReturnAShowView()
    {
        foreach ($this->data as $data) {
            $model = factory($data->class)->create(
                ['desc' => 'another']
            );

            $this->actingAs($this->user)
                ->visit($data->edit . $model->id . '/editar')
                ->type('check', 'desc')
                ->press(trans("aux.{$data->alias}.edit"))
                ->seePageIs($data->show . 'check');
        }
    }

    public function testEditAuxShouldDeleteWithWarning()
    {
        foreach ($this->data as $data) {
            $model = factory($data->class)->create(['desc' => 'testing']);

            $this->actingAs($this->user)
                ->visit($data->show . $model->desc)
                ->press('Eliminar')
                ->seePageIs($data->index);
        }
    }
}
