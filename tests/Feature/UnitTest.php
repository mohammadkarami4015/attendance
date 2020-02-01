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
            ->assertViewIs('admin.units.create')
            ->assertSeeText('ایجاد');
    }





    public function test_title_required_in_create_new_unit()
    {
        $response = $this->post(route('units.store'))
            ->assertSessionHasErrors(['title' => 'عنوان اجباری است']);


    }

    public function test_title_must_be_character()
    {
        $response = $this->post(route('units.store'), [
            'title' => '55555'
        ])
            ->assertSessionHasErrors(['title' => 'عنوان وارد شده صحیح نمی باشد']);
    }

    public function test_title_must_be_less_than_20_character()
    {
        $response = $this->post(route('units.store'), [
            'title' => str_repeat('m', 21)
        ])
            ->assertSessionHasErrors(['title' => 'عنوان وارد شده باید کمتر از 20 کاراکتر باشد']);
    }

    public function test_title_must_be_greater_than_4_character()
    {
        $response = $this->post(route('units.store'), [
            'title' => str_repeat('m', 3)
        ])
            ->assertSessionHasErrors(['title' => 'عنوان وارد شده باید بیشتر از 4 کاراکتر باشد']);
    }

    public function test_title_should_not_be_duplicate()
    {
        factory(Unit::class)->create(['title' => 'test']);
        $response = $this->post(route('units.store'), [
            'title' => 'test'
        ])
            ->assertSessionHasErrors(['title' => 'عنوان وارد شده  تکراری می باشد']);
    }

    public function test_can_insert_new_unit()
    {
        $response = $this->post(route('units.store', [
            'title' => 'test'
        ]));
        $this->assertDatabaseHas('units', ['title' => 'test']);
    }

    public function test_can_see_flash_message_after_insert_new_unit()
    {
        $response = $this->post(route('units.store', [
            'title' => 'test'
        ]))->assertSessionHas(['flash_message' => 'عنوان جدید با موفقیت ثبت شد']);

    }

    public function test_can_delete_unit()
    {
        $unit = factory(Unit::class)->create();
        $response = $this->delete(route('units.destroy', $unit->id));
        $this->assertCount(0, Unit::all());
    }

    public function test_can_see_flash_message_after_delete_unit()
    {
        $unit = factory(Unit::class)->create();
        $response = $this->delete(route('units.destroy', $unit->id))
            ->assertSessionHas(['flash_message' => 'گروه کاری مورد نظر با موفقیت حذف شد']);
    }

    public function test_can_see_unit_edit_form()
    {
        $unit = factory(Unit::class)->create();
        $response = $this->get(route('units.edit', $unit->id))
            ->assertViewIs('admin.units.edit')
            ->assertSee($unit->title);
    }

    public function test_can_update_current_unit()
    {
        $unit = factory(Unit::class)->create();
        $response = $this->patch(route('units.update', $unit->id),['title' => 'updated  test'])
        ->assertSessionHas(['flash_message'=>'گروه کاری مورد نظر با موفقیت ویرایش شد']);
    }
}
