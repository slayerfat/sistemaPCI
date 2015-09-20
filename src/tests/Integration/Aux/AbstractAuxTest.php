<?php namespace Tests\Integration\Aux;

use PCI\Models\User;
use stdClass;
use Tests\Integration\AbstractIntegrationTest;

abstract class AbstractAuxTest extends AbstractIntegrationTest
{

    /**
     * @var \StdClass[]
     */
    protected $data = [];

    /**
     * @var \PCI\Models\User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'confirmation_code' => null,
            'profile_id' => User::ADMIN_ID
        ]);
    }

    /**
     * @param string $name
     * @param string $alias
     * @param string $class
     * @return void
     */
    protected function setData($name, $alias, $class)
    {
        $stdObj          = new StdClass;
        $stdObj->class   = $class;
        $stdObj->alias   = $alias;
        $stdObj->name    = $name;
        $stdObj->index   = $name;
        $stdObj->show    = "$name/";
        $stdObj->create  = "$name/crear";
        $stdObj->edit    = "$name/";
        $stdObj->update  = "$name/";
        $stdObj->destroy = "$name/";

        $this->data[] = $stdObj;
    }
}
