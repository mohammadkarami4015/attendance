@foreach ($singleTimeSheet as $date => $timeSheets)
    <tr>
        <td>
            {{\App\Helpers\DateFormat::toJalali($date)->formatJalaliDate()}}

        </td>
        <td>
            @foreach ($timeSheets as $user => $timeSheet)

                {{\App\Helpers\Name::userFullName(\App\User::find($user))}}
            @endforeach
        </td>
    </tr>
@endforeach


