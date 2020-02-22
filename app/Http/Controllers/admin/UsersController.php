<?php

namespace App\Http\Controllers\admin;

use App\Helper\message;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Shift;
use App\Unit;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use someNamespaceA\NamespacedClass;

class UsersController extends Controller
{

    public function index()
    {

        return view('admin.users.index', [
            'users' => User::query()->latest()->paginate(20),
            'units' => Unit::all(),
            'shifts' => Shift::all()
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

    public function changePasswordForm()
    {
        return view('admin.users.changePassword', ['users' => User::all()]);
    }

    public function changePassword(PasswordRequest $request)
    {
        $user = User::query()->findOrFail($request->get('user_id'));
        $user->update(['password' => bcrypt($request->get('password'))]);
        message::show('رمز عبور باموفقیت ثبت شد');
        return back();
    }

    public function searchByCode(Request $request)
    {
        $users = User::Search($request->get('data'))->get();
        return view('admin.users.Ajax', compact('users'));
    }

    public function filterByUnit(Request $request)
    {
        if ($request->get('unit_id') != 0) {
            $users = User::filterByUnit(explode(',', $request->unit_id))->latest()->get();
        } else {
            $users = User::query()->latest()->paginate(20);
        }
        return view('admin.users.Ajax', compact('users'));

    }

    public function filterByShift(Request $request)
    {
        if ($request->get('shift_id') != 0) {
            $users = User::filterByShift(explode(',', $request->get('shift_id')))->latest()->get();
        } else {
            $users = User::query()->latest()->paginate(20);
        }
        return view('admin.users.Ajax', compact('users'));

    }

}
