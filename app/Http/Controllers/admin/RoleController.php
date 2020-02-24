<?php

namespace App\Http\Controllers\admin;

use App\Helper\message;
use App\Http\Requests\RoleRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use function PHPUnit\Framework\StaticAnalysis\HappyPath\AssertIsArray\consume;

class RoleController extends Controller
{

    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::all(),
            'index' => 1
        ]);
    }


    public function create()
    {

    }


    public function store(RoleRequest $request)
    {
        Role::query()->create($request->validated());
        message::show('نقش جدید با موفقیت اضافه شد');
        return back();
    }


    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));

    }


    public function edit(Role $role)
    {
        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => Permission::all(),
            'permission_index' => implode(',', Permission::all()->pluck('id')->toArray())
        ]);

    }


    public function update(Role $role, RoleRequest $request)
    {
        $role->update($request->validated());
        $role->permissions()->sync($request->get('permissions'));
        message::show('نقش مورد نظر با موفقیت ویرایش شد');
        return back();
    }


    public function destroy(Role $role)
    {
        try {
            $role->delete();
        } catch (\Exception $e) {
        }
        return back();
    }
}
