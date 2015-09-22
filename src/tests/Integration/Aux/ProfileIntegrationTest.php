<?php namespace Tests\Integration\Aux;

use PCI\Models\Profile;

/**
 * Class ProfileIntegrationTest
 * @package Tests\Integration\Aux
 * Nota: se extiende AuxIntegrationTest para que
 * se ejecuten las pruebas heredadas.
 */
class ProfileIntegrationTest extends AuxIntegrationTest
{

    /**
     * como estas entidades son tan genericas, solo se necesita
     * saber el nombre en la ruta , el alias y la clase para
     * crear nuevos registros y objetos en las vistas
     * @return array<string, string, \PCI\Models\AbstractBaseModel>
     */
    public function dataProvider()
    {
        return [
            'test_0_profiles' => [
                'perfiles', 'profiles', Profile::class
            ],
        ];
    }

    /**
     * Se sobreescribe este metodo porque por defecto
     * el sistema tiene al menos 3 perfiles.
     * @param $route
     * @param $alias
     * @param $class
     * @dataProvider dataProvider
     */
    public function testAuxIndexShouldHaveTableWithValidInfo($route, $alias, $class)
    {
        $model = $class::first();

        $this->actingAs($this->user)
            ->visit(route("$alias.index"))
            ->seePageIs("/$route")
            ->see($model->desc);
    }
}
