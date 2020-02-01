<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\VacationType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class VacationTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_can_define_types_of_leaves()
    {
        $this->post(route('vacationType.store', [
            'title' =>  'deserve leave',
            'default_amount' => 17,
        ]));

        $this->post(route('vacationType.store', [
            'title' =>  'sick leave',
            'default_amount' => 3,
        ]));

        //dd($vacationType);
        $this->assertDatabaseHas('vacation_types', [
            'title' => 'deserve leave',
            'default_amount' => 17,
        ]);

        $this->assertDatabaseHas('vacation_types', [
            'title' => 'sick leave',
            'default_amount' => 3,
        ]);
    }

    public function test_admin_can_associate_specific_leaves_to_users_with_amount()
    {
        Role::create(['title' => 'admin']);

        Role::create(['title' => 'user']);

        $user = $this->signIn();

        $user->setAdmin();

        //dd($user);

        factory(User::class, 3)->create();

        $user1 = User::find(1);
        $user2 = User::find(2);
        $user3 = User::find(3);

        $deserveLeave = VacationType::create(['title' => 'استحقاقی']);
        $sickLeave = VacationType::create(['title' => 'استعلاجی']);
        $withoutPayLeave = VacationType::create(['title' => 'بدون حقوق']);


        $user1->setSpecialVacation($deserveLeave, 1020);
        $user1->setSpecialVacation($sickLeave, 4320);
        $user1->setSpecialVacation($withoutPayLeave, 0);

      //  $user2->setSpecialVacation($deserveLeave, 1020);
     //   $user2->setSpecialVacation($sickLeave, 4320);
      //  $user2->setSpecialVacation($withoutPayLeave, 0);

         $this->assertTrue($user1->getSpecialVacation());
         $this->assertNotTrue($user2->getSpecialVacation());


      //  $this->assert

        //dd($user1->getTotalLeave($deserveLeave));

    }
}
