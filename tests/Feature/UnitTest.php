<?php

namespace Tests\Feature;

use App\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnitTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_see_unit_list()
    {
        $this->withExceptionHandling();
        $unit = factory(Unit::class)->create(['title' => 'sample']);
        $response = $this->get(route('units.index'))
            ->assertViewIs('admin.units.index')
            ->assertSeeText('sample')
            ->assertSeeText('ویرایش');
    }

    public function test_can_see_unitCreate_form()
    {
        $response = $this->get(route('units.create'));
        $response->assertStatus(200)
        ->assertViewIs('admin.unit.create');
    }

    public function test()
    {
        
    }



    public function test_title_required_in_create_new_unit()
    {

    }


    public function test_can_insert_new_unit()
    {
        $this->withExceptionHandling();
        $response = $this->post(route('units.store', [
      'fkdlfks'=>'fld;fld'
        ]));
        $response->assertStatus(200);
    }
}
