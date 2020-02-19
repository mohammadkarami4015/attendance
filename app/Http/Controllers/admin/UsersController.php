<?php

namespace App\Http\Controllers\admin;

use App\Helper\message;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Unit;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        return view('admin.users.index', [
            'users' => User::query()->latest()->paginate(20),
        ]);
    }


    public function create()
    {
        return view('admin.users.create', ['units' => Unit::all()]);
    }


    public function store(UserRequest $request)
    {

        $user = User::create(array_merge(
            ['password' => bcrypt($request->get('national_code'))],
            $request->validated()
        ));
//        $user->addDefaultRole();
        message::show('کاربر جدید با موفقیت ثبت شد');
        return redirect(route('users.index'));


    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user, 'units' => Unit::all()]);
    }


    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        message::show('کاربر مورد نظر با موفقیت ویرایش شد');
        return back();
    }


    public function destroy(User $user)
    {

        $user->delete();
        message:: show('کاربر مورد نظر حذف شد');
        return back();
    }

}
