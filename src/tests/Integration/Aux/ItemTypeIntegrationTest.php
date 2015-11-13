<?php namespace Tests\Integration\Aux;

use PCI\Models\ItemType;

/**
 * Class ItemTypeIntegrationTest
 * Nota: se extiende AuxIntegrationTest para que
 * se ejecuten las pruebas heredadas.
 *
 * @package Tests\Integration\Aux
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class ItemTypeIntegrationTest extends AbstractAuxIntegration
{

    /**
     * como estas entidades son tan genericas, solo se necesita
     * saber el nombre en la ruta , el alias y la clase para
     * crear nuevos registros y objetos en las vistas
     *
     * @return array
     */
    public function dataProvider()
    {
        return [
            'test_items' => [
                'tipos-item',
                'itemTypes',
                ItemType::class,
            ],
        ];
    }

    /**
     * @param $route
     * @param $alias
     * @dataProvider dataProvider
     */
    public function testAuxIndexShouldHaveTableWithValidInfo(
        $route,
        $alias
    ) {
        $this->actingAs($this->user)
            ->visit(route("$alias.index"))
            ->seePageIs("/$route")
            ->see('No hay información que mostrar.');
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
            ->check('perishable')
            ->type('testing', 'desc')
            ->press(trans("models.{$alias}.create"))
            ->seePageIs("{$route}/testing");
    }

    /**
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testEditAuxShouldReturnAForm($route, $alias, $class)
    {
        $model = factory($class)->create([
            'desc'       => 'testing',
            'perishable' => false,
        ]);

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
        $model = factory($class)->create([
            'desc'       => 'testing',
            'perishable' => false,
        ]);

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->id}/editar")
            ->type('check', 'desc')
            ->press(trans("models.$alias.edit"))
            ->seePageIs("{$route}/check");
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
        $model = factory($class)->create([
            'desc'       => 'testing',
            'perishable' => false,
        ]);

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->desc}")
            ->press('Eliminar')
            ->seePageIs("/{$route}");
    }
}
