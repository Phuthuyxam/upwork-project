@if(isset($bookingType) && !empty($bookingType))
<div class="reservation-form" style="background-image: url({{ asset('client/images/MaskGroup31.jpg') }});">
    <h4 class="fw-bold">{{ __('booking_form_reservation') }}</h4>

    @if($bookingType->type == \App\Core\Glosary\BookingTypes::LINK['VALUE'])
        <div class="submit-wrapper">
            <a href="{{ $bookingType->value }}" class="btn btn-submit">Click here</a>
        </div>
    @elseif($bookingType->type == \App\Core\Glosary\BookingTypes::FORM['VALUE'])
        <form action="" method="post">
            <div class="date-input">
                <div class="icon-calendar">
                    <img src="{{ asset('client/images/Icon feathercalendar.svg') }}" alt="">
                </div>
                <input type="text" name="start" class="form-control detail-date-picker" value=""
                       placeholder="{{ __('home_check_in') }}" required="required" title="">
            </div>
            <div class="date-input">
                <div class="icon-calendar">
                    <img src="{{ asset('client/images/Icon feathercalendar.svg') }}" alt="">
                </div>
                <input type="text" name="end" class="form-control detail-date-picker" value=""
                       placeholder="{{ __('home_check_out') }}" required="required" title="">
            </div>
            <select class="form-control" name="adult">
                <option value="default">{{ __('booking_form_adult') }}</option>
                <option value="1">1</option>
                <option value="1">2</option>
                <option value="1">3</option>
                <option value="1">4</option>
            </select>
            <select class="form-control" name="child">
                <option value="default">{{ __('booking_form_child') }}</option>
                <option value="1">1</option>
                <option value="1">2</option>
                <option value="1">3</option>
                <option value="1">4</option>
            </select>
            <div class="submit-wrapper">
                <input type="submit" class="btn btn-submit" value="SUBMIT">
            </div>
        </form>
    @else
        <form action="">
            <div class="date-input">
                <div class="icon-calendar">
                    <img src="{{ asset('client/images/Icon feathercalendar.svg') }}" alt="">
                </div>
                <input type="text" name="" class="form-control detail-date-picker" value=""
                       placeholder="{{ __('home_check_in') }}" required="required" title="">
            </div>
            <div class="date-input">
                <div class="icon-calendar">
                    <img src="{{ asset('client/images/Icon feathercalendar.svg') }}" alt="">
                </div>
                <input type="text" name="" class="form-control detail-date-picker" value=""
                       placeholder="{{ __('home_check_out') }}" required="required" title="">
            </div>
            <select class="form-control" name="">
                <option value="default">{{ __('booking_form_adult') }}</option>
                <option value="1">1</option>
                <option value="1">2</option>
                <option value="1">3</option>
                <option value="1">4</option>
            </select>
            <select class="form-control" name="">
                <option value="default">{{ __('booking_form_child') }}</option>
                <option value="1">1</option>
                <option value="1">2</option>
                <option value="1">3</option>
                <option value="1">4</option>
            </select>
            <div class="submit-wrapper">
                <input type="submit" class="btn btn-submit" value="{{ __('home_check_availability') }}">
            </div>
        </form>
    @endif
</div>
@endif
