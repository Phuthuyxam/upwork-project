@extends('backend.default')
@section('title')
    Booking type Settings
@endsection
@section('style')
    <style>
        .hidden{
            display: none;
        }
        .error {
            border: 1px solid red;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Booking type Settings</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card">
                <h5 class="card-header mt-0 font-size-16">Booking type</h5>
                <form action="{{ route('system.booking_type') }}" method="post" id="bookingType">
                    @csrf
                    <div class="card-body">
                        @if($record)
                            @foreach(\App\Core\Glosary\BookingTypes::getAll() as $value)
                                <div class="form-group" style="display: flex; align-items: center">
                                    <input type="radio" id="{{ $value['ID'] }}" name="booking_type" value="{{ $value['VALUE'] }}" style="margin-right: 1rem" {{ $value['VALUE'] == $record->type ? 'checked' : ''}}>
                                    <label for="{{ $value['ID'] }}" style="margin-bottom: 0">{{ $value['DISPLAY'] }}</label>
                                    <input type="text" name="{{ $value['VALUE'] == $record->type ? 'type_link' : ''}}"
                                           class="form-control type_link required {{ $value['VALUE'] == $record->type ? '' : 'hidden'}}" style="margin-left: 1rem; flex:1;"
                                           placeholder="{{ $value['PLACE_HOLDER'] }}" value="{{$value['VALUE'] == $record->type ? $record->value : ''}}">
                                </div>
                            @endforeach
                        @else
                            @foreach(\App\Core\Glosary\BookingTypes::getAll() as $value)
                                <div class="form-group" style="display: flex; align-items: center">
                                    <input type="radio" id="{{ $value['ID'] }}" name="booking_type" value="{{ $value['VALUE'] }}" style="margin-right: 1rem" {{ $value['VALUE'] == 0 ? 'checked' : ''}}>
                                    <label for="{{ $value['ID'] }}" style="margin-bottom: 0">{{ $value['DISPLAY'] }}</label>
                                    <input type="text" name="{{ $value['VALUE'] == 0 ? 'type_link' : ''}}" class="form-control type_link required {{ $value['VALUE'] == 0 ? '' : 'hidden'}}" style="margin-left: 1rem; flex:1;" placeholder="{{ $value['PLACE_HOLDER'] }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-save-type">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('input[name="booking_type"]').on('change',function (){
                $(this).parents('form').find('.type_link').addClass('hidden');
                $(this).parents('form').find('.type_link').removeClass('error');
                $(this).parents('form').find('.type_link').attr('name','');
                if ($(this).prop("checked")) {
                    $(this).parent().find('.type_link').removeClass('hidden');
                    $(this).parent().find('.type_link').attr('name','type_link');
                }
            })
            $('.btn-save-type').on('click',function (e){
                e.preventDefault();
                let valid = true;
                $(this).parents('form').find('input.required').removeClass('error');
                $(this).parents('form').find('input.required').each(function (){
                    if (!$(this).hasClass('hidden') && $(this).val() == '') {
                        $(this).addClass('error');
                        valid = false;
                    }
                })
                if (valid) {
                    $('#bookingType').submit();
                }
            })
        })
    </script>
@endsection
