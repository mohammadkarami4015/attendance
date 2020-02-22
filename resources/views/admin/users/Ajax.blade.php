@php
    $index = 1;
@endphp
@foreach($users as $user)
    <tr>
        <td>{{$index}}</td>
        <td>
            <a title="نمایش جزيیات"
               href="{{route('users.show',$user->id)}}"> {{\App\Helpers\Name::userFullName($user)}}</a>
        </td>
        <td>{{$user->personal_code}}</td>
        <td>{{$user->national_code}}</td>
        <td> {{optional($user->unit)->title}}</td>
        <td> {{optional(optional($user->unit)->getCurrentShift())->title}}</td>
        <td> تعیین نشده</td>
        <td>
            <form onsubmit="return confirm('آیا مایل به حذف این کاربر هستید؟');"
                  method="POST" action="{{route('users.destroy',$user->id)}}">
                {{csrf_field()}}
                {{method_field('delete')}}

                <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary">ویرایش</a>
                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
            </form>
        </td>
    </tr>
    @php
        $index ++;
    @endphp
@endforeach
