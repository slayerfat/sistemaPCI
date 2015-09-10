<?php namespace PCI\Database;

use PCI\Models\Address;
use PCI\Models\Employee;
use PCI\Models\WorkDetail;

class UserRelatedSeeder extends BaseSeeder
{

    public function run()
    {
        $address = $this->seedAdreess();

        $employee = $this->seedEmployee($address);

        return $this->seedWorkDetails($employee);
    }

    /**
     * @param Address $address
     * @return Employee
     */
    private function seedEmployee(Address $address)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $employee = factory(Employee::class)->make();

        $employee->nationality_id = 1;
        $employee->address_id     = $address->id;
        $employee->gender_id      = 1;

        $this->user->employee()->save($employee);

        $this->command->info("{$employee->first_name}, {$employee->first_surname}.");

        $this->command->comment('Terminado ' . __METHOD__);

        return $employee;
    }

    /**
     * @return Address
     */
    private function seedAdreess()
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $address = factory(Address::class)->make();
        $address->parish_id = 1;

        $address->save();

        $this->command->info("{$address->av}, {$address->street}.");

        $this->command->comment('Terminado ' . __METHOD__);

        return $address;
    }

    /**
     * @param $employee
     * @return WorkDetail
     */
    private function seedWorkDetails($employee)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $workDetails = factory(WorkDetail::class)->make();

        $workDetails->position_id   = 1;
        $workDetails->department_id = 1;

        $employee->workDetails()->save($workDetails);

        $this->command->info("{$employee->first_name}: Date {$workDetails->join_date}.");

        $this->command->comment('Terminado ' . __METHOD__);

        return $workDetails;
    }
}
