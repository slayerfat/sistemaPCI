<?php namespace Tests\PCI\Api\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use PCI\Models\Petition;
use PCI\Models\User;
use Tests\Integration\User\AbstractUserIntegration;

/**
 * Class PetitionControllerTest
 *
 * @package Tests\PCI\Api\User
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class PetitionControllerTest extends AbstractUserIntegration
{

    use WithoutMiddleware;

    public function testStatusShouldReturnOkWhenCorrectDataGiven()
    {
        $this->post(route('api.petitions.status', 1), ['status' => 'true'])
            ->assertResponseOk();
    }

    /**
     * @dataProvider statusIncorrectDataProvider
     * @param $value
     * @param $expected
     */
    public function testStatusShouldReturnCorrectResponse($value, $expected)
    {
        $this->actingAs($this->user)
            ->post(route('api.petitions.status', 1), ['status' => $value])
            ->seeJson([
                'status' => $expected,
            ]);
    }

    public function statusIncorrectDataProvider()
    {
        return [
            'set_0'  => [true, true],
            'set_1'  => [false, true],
            'set_2'  => [null, true],
            'set_3'  => ['true', true],
            'set_4'  => ['false', true],
            'set_5'  => ['null', true],
            'set_6'  => ['a', false],
            'set_7'  => ['1', false],
            'set_8'  => [1, false],
            'set_9'  => [-1, false],
            'set_10' => [[], false],
            'set_11' => [[true], false],
            'set_12' => [[1], false],
        ];
    }

    public function testStatusShouldReturnFalseWhenNoDataGiven()
    {
        $this->actingAs($this->user)
            ->post(route('api.petitions.status', 1))
            ->seeJson([
                'status' => false,
            ]);
    }

    /**
     * @return \PCI\Models\User
     */
    protected function getUser()
    {
        return factory(User::class, 'admin')->create();
    }

    /**
     * @return void
     */
    protected function persistData()
    {
        factory(Petition::class)->create();
    }
}
