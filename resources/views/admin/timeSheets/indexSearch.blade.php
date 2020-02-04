@foreach($timeSheets as $timeSheet)
    <tr>
        <td>
            {{\App\Helpers\Name::userFullName($timeSheet->user)}}
        </td>
        <td>
            {{\App\Helpers\DateFormat::toJalali($timeSheet->finger_print_time)->formatJalaliDate()}}
        </td>

        <td>
            {{\App\Helpers\DateFormat::toJalali($timeSheet->finger_print_time)->formatTime()}}
        </td>

        <td>
            <form onsubmit="return confirm('آیا مایل به حذف این اطلاعات می باشید؟');"
                  method="post"
                  action="{{route('timeSheets.destroy',$timeSheet->id)}}">
                {{csrf_field()}}
                {{method_field('delete')}}
                <div class="btn-group btn-group">
                    <a href="{{route('timeSheets.edit',$timeSheet->id)}}" class="btn btn-primary">ویرایش</a>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </div>
            </form>
        </td>
    </tr>
@endforeach
