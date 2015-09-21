<?php namespace Tests\Integration\Aux;

use PCI\Models\Category;
use PCI\Models\SubCategory;

class SubCategoriesIntegrationTest extends AuxIntegrationTest
{

    /**
     * @var \PCI\Models\Category
     */
    private $cat;

    public function setUp()
    {
        parent::setUp();

        $this->cat = factory(Category::class)->create();
    }

    /**
     * como estas entidades son tan genericas, solo se necesita
     * saber el nombre en la ruta , el alias y la clase para
     * crear nuevos registros y objetos en las vistas
     * @return array<string, string, \PCI\Models\AbstractBaseModel>
     */
    public function dataProvider()
    {
        return [
            'test_0_subCats' => [
                'rubros', 'subCats', SubCategory::class
            ],
        ];
    }

    /**
     * Los rubros tienen cat_id
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testAuxIndexShouldHaveTableWithValidInfo($route, $alias, $class)
    {
        $this->actingAs($this->user)
            ->visit(route("$alias.index"))
            ->seePageIs("/$route")
            ->see('No hay información que mostrar.');

        $model = factory($class)->create(['category_id' => $this->cat->id]);

        $this->actingAs($this->user)
            ->visit(route("$alias.index"))
            ->see($model->desc);
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
            ->type($this->cat->id, 'category_id')
            ->select('testing', 'desc')
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
            'desc' => 'testing',
            'category_id' => $this->cat->id
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
                'desc' => 'another',
                'category_id' => $this->cat->id
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
            'desc' => 'testing',
            'category_id' => $this->cat->id
        ]);

        $this->actingAs($this->user)
            ->visit("{$route}/{$model->desc}")
            ->press('Eliminar')
            ->seePageIs("/{$route}");
    }
}
