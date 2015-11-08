<?php namespace Tests\Integration\Aux;

use PCI\Models\Category;
use PCI\Models\Department;
use PCI\Models\Gender;
use PCI\Models\Maker;
use PCI\Models\MovementType;
use PCI\Models\Nationality;
use PCI\Models\Position;
use PCI\Models\StockType;

class AuxIntegrationTest extends AbstractAuxIntegration
{

    /**
     * como estas entidades son tan genericas, solo se necesita
     * saber el nombre en la ruta , el alias y la clase para
     * crear nuevos registros y objetos en las vistas
     *
     * @return array<string, string, \PCI\Models\AbstractBaseModel>
     */
    public function dataProvider()
    {
        return [
            'test_cats'          => [
                'categorias',
                'cats',
                Category::class,
            ],
            'test_depts'         => [
                'departamentos',
                'depts',
                Department::class,
            ],
            'test_genders'       => [
                'generos',
                'genders',
                Gender::class,
            ],
            'test_makers'        => [
                'fabricantes',
                'makers',
                Maker::class,
            ],
            'test_movementTypes' => [
                'tipos-movimiento',
                'movementTypes',
                MovementType::class,
            ],
            'test_nats'          => [
                'nacionalidades',
                'nats',
                Nationality::class,
            ],
            'test_positions'     => [
                'cargos',
                'positions',
                Position::class,
            ],
            'test_stockType'     => [
                'tipos-cantidad',
                'stockTypes',
                StockType::class,
            ],
        ];
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testAuxIndexShouldHaveTableWithValidInfo(
        $route,
        $alias,
        $class
    ) {
        $this->actingAs($this->user)
            ->visit(route("$alias.index"))
            ->seePageIs("/$route")
            ->see('No hay información que mostrar.');

        $model = factory($class)->create();

        $this->actingAs($this->user)
            ->visit(route("$alias.index"))
            ->see($model->desc);
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testUserShouldSeeCreateAuxOptions($route, $alias, $class)
    {
        unset($route);
        unset($class);
        $this->actingAs($this->user)
            ->visit(route('index'))
            ->see(trans("models.{$alias}.index"));
    }

    /**
     * @param $route
     * @param $alias
     * @dataProvider dataProvider
     */
    public function testCreateAuxShouldReturnAForm($route, $alias)
    {
        $this->actingAs($this->user)
            ->visit(route('index'))
            ->click(trans("models.{$alias}.index"))
            ->seePageIs("/{$route}")
            ->see(trans("models.{$alias}.create"))
            ->click(trans("models.{$alias}.create"))
            ->seePageIs("{$route}/crear");
    }

    /**
     * @param $route
     * @param $alias
     * @dataProvider dataProvider
     */
    public function testCreatingAuxShouldReturnAShowView($route, $alias)
    {
        $this->actingAs($this->user)
            ->visit("{$route}/crear")
            ->type('testing', 'desc')
            ->press(trans("models.{$alias}.create"))
            ->seePageIs("{$route}/testing")
            ->see(trans("models.{$alias}.store.success"));
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testEditAuxShouldReturnAForm($route, $alias, $class)
    {
        $model = factory($class)->create(['desc' => 'testing']);

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->desc}")
            ->click('Editar')
            ->seePageIs("{$route}/{$model->id}/editar")
            ->see(trans("models.$alias.edit"));
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testEditingAuxShouldReturnAShowView($route, $alias, $class)
    {
        $model = factory($class)->create(
            ['desc' => 'another']
        );

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->id}/editar")
            ->type('check', 'desc')
            ->press(trans("models.$alias.edit"))
            ->seePageIs("{$route}/check")
            ->see(trans("models.{$alias}.update.success"));
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testEditAuxShouldDeleteWithWarning($route, $alias, $class)
    {
        unset($alias);
        $model = factory($class)->create(['desc' => 'testing']);

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->desc}")
            ->press('Eliminar')
            ->seePageIs("/{$route}");
    }
}
