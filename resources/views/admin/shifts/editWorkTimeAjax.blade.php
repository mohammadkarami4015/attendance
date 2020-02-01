<div class="">
    @foreach($workTime as $time)
        <div class="">
            <div class="checkbox">
                <label>
                    <input name="workTimes[]" value="{{$time->id}}" type="checkbox"
                           id="day">
                    شروع :{{$time->start  }}     پایان:    {{ $time->end }}

                </label>
            </div>
        </div>
    @endforeach
</div>

