<?php namespace Tests\PCI\Models\User\Employee;

use PCI\Models\Employee;
use Tests\BaseTestCase;

class EmployeeTest extends BaseTestCase
{

    /**
     * @var Employee
     */
    private $employee;

    public function setUp()
    {
        parent::setUp();

        $this->employee = factory(Employee::class)->make();
    }

    public function testFormattedNamesShouldReturnReadableString()
    {
        $this->employee->first_name = 'tetsuo';
        $this->employee->first_surname = 'kaneda';

        $this->employee->last_name = 'tester';
        $this->employee->last_surname = 'martinez';

        $this->assertEquals('Kaneda, Tetsuo', $this->employee->formattedNames());
        $this->assertEquals('Kaneda Martinez, Tetsuo Tester', $this->employee->formattedNames(true));

        unset($this->employee->last_name);

        $this->assertEquals('Kaneda Martinez, Tetsuo', $this->employee->formattedNames(true));

        $this->employee->last_name = 'otro';
        unset($this->employee->last_surname);

        $this->assertEquals('Kaneda, Tetsuo Otro', $this->employee->formattedNames(true));
    }
}
