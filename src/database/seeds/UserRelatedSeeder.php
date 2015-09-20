<?php namespace PCI\Database;

use PCI\Models\Address;
use PCI\Models\Attendant;
use PCI\Models\Employee;
use PCI\Models\User;
use PCI\Models\WorkDetail;

class UserRelatedSeederAbstract extends AbstractBaseSeeder
{

    public function run()
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $users = collect();

        // El usuario principal
        $users->push($this->user);

        $password = bcrypt(env('APP_USERS_PASSWORD'));

        // se crean usuarios adicionales para probar autenticacion y autorizacion.
        $user = factory(User::class)->create([
            'profile_id'  => 2,
            'password' => $password
        ]);
        $users->push($user);

        // usuario 2 es encargado de almacen
        factory(Attendant::class)->create(['user_id' => 2]);
        $this->command->info("creado Jefe de Alamacen");



        $user = factory(User::class)->create([
            'profile_id'  => 3,
            'password' => $password
        ]);
        $users->push($user);

        $users->each(function ($user) {
            $this->command->line("En el bucle de {$user->name}");

            $address = $this->seedAdreess();

            $employee = $this->seedEmployee($user, $address);

            return $this->seedWorkDetails($employee);
        });
    }

    /**
     * @param User $user
     * @param Address $address
     * @return Employee
     */
    private function seedEmployee(User $user, Address $address)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $employee = factory(Employee::class)->make();

        $employee->nationality_id = 1;
        $employee->address_id     = $address->id;
        $employee->gender_id      = 1;

        $user->employee()->save($employee);

        $this->command->info("{$employee->first_name}, {$employee->first_surname}.");

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

        return $address;
    }

    /**
     * @param Employee $employee
     * @return WorkDetail
     */
    private function seedWorkDetails(Employee $employee)
    {
        $this->command->comment('Empezando ' . __METHOD__);

        $workDetails = factory(WorkDetail::class)->make();

        $workDetails->position_id   = 1;
        $workDetails->department_id = 1;

        $employee->workDetails()->save($workDetails);

        $this->command->info("{$employee->first_name}: Date {$workDetails->join_date}.");

        return $workDetails;
    }
}
