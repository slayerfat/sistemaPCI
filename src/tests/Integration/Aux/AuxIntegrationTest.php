<?php namespace Tests\Integration\Aux;

use PCI\Models\Category;
use PCI\Models\Department;
use PCI\Models\Gender;
use PCI\Models\ItemType;
use PCI\Models\Maker;
use PCI\Models\MovementType;

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
            ['generos', 'genders', Gender::class],
            ['tipos-item', 'itemTypes', ItemType::class],
            ['fabricantes', 'makers', Maker::class],
            ['tipos-movimiento', 'movementTypes', MovementType::class],
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

            $model = factory($data->class)->create();

            $this->actingAs($this->user)
                ->visit($data->index)
                ->see($model->desc);
        }
    }

    public function testUserShouldSeeCreateAuxOptions()
    {
        foreach ($this->data as $data) {
            $this->actingAs($this->user)
                ->visit(route('index'))
                ->see(trans("models.{$data->alias}.index"));
        }
    }

    public function testCreateAuxShouldReturnAForm()
    {
        foreach ($this->data as $data) {
            $this->actingAs($this->user)
                ->visit(route('index'))
                ->click(trans("models.{$data->alias}.index"))
                ->seePageIs($data->index)
                ->see(trans("models.{$data->alias}.create"))
                ->click(trans("models.{$data->alias}.create"))
                ->seePageIs($data->create);
        }
    }

    public function testCreatingAuxShouldReturnAShowView()
    {
        foreach ($this->data as $data) {
            $this->actingAs($this->user)
                ->visit($data->create)
                ->type('testing', 'desc')
                ->press(trans("models.{$data->alias}.create"))
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
                ->press(trans("models.{$data->alias}.edit"))
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
