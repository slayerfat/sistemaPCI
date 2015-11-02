<?php namespace Tests\PCI\Api\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use PCI\Events\Petition\PetitionApprovalRequest;
use PCI\Models\Item;
use PCI\Models\MovementType;
use PCI\Models\Petition;
use PCI\Models\PetitionType;
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
        /** @var Petition $petition */
        $petition         = Petition::first();
        $petition->status = null;
        $petition->save();
        $this->withoutEvents();

        $this->actingAs($this->user)
            ->post(route('api.petitions.status', $petition->id), ['status' => $value])
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

    public function testItemsShouldReturnOk()
    {
        $this->post(route('api.petitions.items', 1))
            ->assertResponseOk();
    }

    public function testItemsShouldReturnValidJson()
    {
        /** @var Item $item */
        $item = Item::first();

        $this->post(route('api.petitions.items'), ['id' => 1])
            ->seeJson([
                'id'       => $item->id,
                'desc'     => $item->desc,
                'stock'    => $item->formattedStock(),
                'quantity' => $item->petitions->first()->pivot->quantity,
            ]);
    }

    public function testApprovalRequestShouldReturnOk()
    {
        $this->actingAs($this->user)
            ->expectsEvents(PetitionApprovalRequest::class)
            ->post(route('api.petitions.approvalRequest', 1))
            ->assertResponseOk();
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
        // necesitamos tipo de movimiento para verificar pedido
        $movementType = factory(MovementType::class)->create(['desc' => 'Entrada']);
        $petitionType = factory(PetitionType::class)->create(['movement_type_id' => $movementType->id]);
        $petition     = factory(Petition::class)->create(['petition_type_id' => $petitionType->id]);
        $item     = factory(Item::class, 'full')->create();
        $petition->items()->attach($item->id, [
            'quantity' => $item->stock(),
            'stock_type_id' => $item->stock_type_id,
        ]);
    }
}
