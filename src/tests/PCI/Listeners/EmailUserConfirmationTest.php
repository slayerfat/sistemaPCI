<?php namespace Tests\PCI\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use Mockery;
use PCI\Events\NewUserRegistration;
use PCI\Listeners\EmailUserConfirmation;
use PCI\Models\User;
use stdClass;
use Tests\BaseTestCase;

class EmailUserConfirmationTest extends BaseTestCase
{

    private $event;

    public function setUp()
    {
        parent::setUp();

        $mailer = Mockery::mock(Mailer::class)->makePartial();
        $mailer->shouldReceive('send')->once()->withAnyArgs();

        $this->event = new EmailUserConfirmation($mailer);
    }

    public function testEmailShouldBeFired()
    {
        $user = factory(User::class)->make();
        $this->assertEquals(null, $this->event->handle(new NewUserRegistration($user)));
    }
}
