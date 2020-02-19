<?php

namespace App\Http\Controllers\admin;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{

    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::all(),
            'index' => 1,
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        Role::create([
            'title' => $request->get('title'),

        ]);

        return back();
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Role $role,Request $request)
    {
        //dd($role);
        $role->update(['title' => $request->get('title')]);

        return redirect()->action('admin\RoleController@index');
    }


    public function destroy(Role $role)
    {
        $role->delete();

        return back();
    }
}
