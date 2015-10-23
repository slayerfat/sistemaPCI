<?php namespace Tests\PCI\Models\Traits;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PCI\Models\Petition;
use PCI\Models\PetitionType;
use PCI\Models\User;
use Tests\AbstractTestCase;

/**
 * Class HasTernaryStatusAttributeTest
 *
 * @package Tests\PCI\Models\Traits
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class HasTernaryStatusAttributeTest extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();

        $user     = factory(User::class, 'admin')->create();
        $petType  = factory(PetitionType::class)->create();
        $petition = new Petition();

        $petition->status           = false;
        $petition->request_date     = '1999-09-09';
        $petition->user_id          = $user->id;
        $petition->petition_type_id = $petType;
        $petition->save();
    }

    /**
     * @dataProvider statusDataProvider
     * @param $status
     * @param $actual
     */
    public function testStatusShouldBeValid($status, $actual)
    {
        /** @var Petition $petition */
        $petition         = Petition::first();
        $petition->status = $status;
        $petition->save();

        $this->seeInDatabase('petitions', ['status' => $actual]);
    }

    public function statusDataProvider()
    {
        return [
            'set_1' => [true, 1],
            'set_2' => ["true", 1],
            'set_3' => [false, 0],
            'set_4' => ["false", 0],
            'set_5' => [null, null],
            'set_6' => ["null", null],
            'set_7' => ["a", 0],
            'set_8' => [1, 0],
            'set_9' => [-1, 0],
        ];
    }
}
