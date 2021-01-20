<div class="card">
    <h5 class="card-header mt-0 font-size-16">Booking type</h5>
    <div id="bookingType">
        @csrf
        <div class="card-body">
            @if(isset($record) && !empty($record))
                @foreach(\App\Core\Glosary\BookingTypes::getAll() as $value)
                    <div class="form-group">
                        <input type="radio" id="{{ $value['ID'] }}" name="booking_type" value="{{ $value['VALUE'] }}" style="margin-right: 1rem" {{ $value['VALUE'] == $record->type ? 'checked' : ''}}>
                        <label for="{{ $value['ID'] }}" style="margin-bottom: 0">{{ $value['DISPLAY'] }}</label>
                        <input type="{{ $value['VALUE'] == \App\Core\Glosary\BookingTypes::FORM['VALUE'] ? 'email' : 'text'}}" name="{{ $value['VALUE'] == $record->type ? 'type_link' : ''}}"
                               class="form-control type_link required {{ $value['VALUE'] == $record->type ? '' : 'hidden'}}" style="margin-top: .5rem;"
                               placeholder="{{ $value['PLACE_HOLDER'] }}" value="{{$value['VALUE'] == $record->type ? $record->value : ''}}">
                        <p class="text-danger error-message" style="font-weight: bold"></p>
                    </div>
                @endforeach
            @else
                @foreach(\App\Core\Glosary\BookingTypes::getAll() as $value)
                    <div class="form-group">
                        <div class="radio-wrapper">
                            <input type="radio" id="{{ $value['ID'] }}" name="booking_type" value="{{ $value['VALUE'] }}" style="margin-right: 1rem" {{ $value['VALUE'] == 0 ? 'checked' : ''}}>
                            <label for="{{ $value['ID'] }}" style="margin-bottom: 0">{{ $value['DISPLAY'] }}</label>
                        </div>
                        <input type="{{ $value['VALUE'] == \App\Core\Glosary\BookingTypes::FORM['VALUE'] ? 'email' : 'text'}}" name="{{ $value['VALUE'] == 0 ? 'type_link' : ''}}" class="form-control type_link {{ $value['VALUE'] == 0 ? 'required' : 'hidden'}}" style="margin-top: .5rem;" placeholder="{{ $value['PLACE_HOLDER'] }}">
                        <p class="text-danger error-message" style="font-weight: bold"></p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

