@if(isset($bookingType) && !empty($bookingType))
<div class="reservation-form" style="background-image: url({{ asset('client/images/MaskGroup31.jpg') }});">
    <h4 class="fw-bold">{{ __('booking_form_reservation') }}</h4>

    @if($bookingType->type == \App\Core\Glosary\BookingTypes::LINK['VALUE'])
        <div class="submit-wrapper">
            <a href="{{ $bookingType->value }}" class="btn btn-submit">Click here</a>
        </div>
    @elseif($bookingType->type == \App\Core\Glosary\BookingTypes::FORM['VALUE'])
        <form action="{{ route('booking')}}" id="detail-booking" method="post">
            @csrf
            <input type="hidden" name="type" value="{{ $bookingType->type }}">
            <input type="hidden" name="postId" value="{{ $post->id }}">
            <div class="date-input-wrapper form-group">
                <div class="date-input">
                    <div class="icon-calendar">
                        <img src="{{ asset('client/images/Icon feathercalendar.svg') }}" alt="">
                    </div>
                    <input type="text" id="arrival" name="start" class="form-control detail-date-picker required" value=""
                           placeholder="{{ __('home_check_in') }}" required="required" title="" readonly>
                </div>
                <p class="text-danger error" style="font-weight: bold"> {{__('required_error')}}</p>
            </div>
            <div class="date-input-wrapper form-group">
                <div class="date-input">
                    <div class="icon-calendar">
                        <img src="{{ asset('client/images/Icon feathercalendar.svg') }}" alt="">
                    </div>
                    <input type="text" id="departure" name="end" class="form-control detail-date-picker required" value=""
                           placeholder="{{ __('home_check_out') }}" required="required" title="" readonly>
                </div>
                <p class="text-danger error" style="font-weight: bold">{{__('required_error')}}</p>
            </div>
            <div class="form-group">
                <select class="form-control required" id="adults" name="adults">
                    <option value="-1">{{ __('booking_form_adult') }}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <p class="text-danger error" style="font-weight: bold">{{__('required_error')}}</p>
            </div>
            <div class="form-group">
                <select class="form-control" id="children" name="child">
                    <option value="-1">{{ __('booking_form_child') }}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <p class="text-danger error" style="font-weight: bold">{{__('required_error')}}</p>
            </div>
            <div class="form-group children-age-wrapper">
                <p class="fw-bold tt-uper" style="margin-bottom: 0">{{__('children_age_text')}}</p>

                @for($i = 0 ; $i < 5; $i++)
                    <select class="children-age" name="childrenAge[]" id="">
                        <option value="-1">-</option>
                        @for($j = 0; $j <= 11; $j++)
                            <option value="{{ $j }}">{{ $j }}</option>
                        @endfor
                    </select>
                @endfor

                <p class="error text-danger fw-bold">{{__('children_age_error')}}</p>
            </div>
            <div class="submit-wrapper">
                <input type="submit" class="btn btn-submit btn-send-mail" value="SUBMIT">
            </div>
        </form>
    @else
        <form action="https://bookcore.backhotelengine.com/redirect-avail/" id="detail-booking" method="post">
            <input type="hidden" name="partner">
            <input type="hidden" name="lange" value="{{ $currentLanguage }}">
            <input type="hidden" name="hotel_code" value="{{ $bookingType->value }}">
            <div class="date-input-wrapper form-group">
                <div class="date-input ">
                    <div class="icon-calendar">
                        <img src="{{ asset('client/images/Icon feathercalendar.svg') }}" alt="">
                    </div>
                    <input type="text" id="arrival" name="arrival" class="form-control detail-date-picker required" value=""
                           placeholder="{{ __('home_check_in') }}" required="required" title="" readonly>
                </div>
                <p class="error text-danger fw-bold">{{__('required_error')}}</p>
            </div>
            <div class="date-input-wrapper form-group">
                <div class="date-input">
                    <div class="icon-calendar">
                        <img src="{{ asset('client/images/Icon feathercalendar.svg') }}" alt="">
                    </div>
                    <input type="text" id="departure" name="departure" class="form-control detail-date-picker required" value=""
                           placeholder="{{ __('home_check_out') }}" required="required" title="" readonly>
                </div>
                <p class="error text-danger fw-bold">{{__('required_error')}}</p>
            </div>
            <div class="form-group">
                <select class="form-control required" id="adults" name="">
                    <option value="-1">{{ __('booking_form_adult') }}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <p class="error text-danger fw-bold">{{__('required_error')}}</p>
            </div>
            <div class="form-group">
                <select class="form-control required" id="children" name="">
                    <option value="0">{{ __('booking_form_child') }}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group children-age-wrapper">
                <p class="fw-bold tt-uper" style="margin-bottom: 0">{{__('children_age_text')}}</p>

                @for($i = 0 ; $i < 5; $i++)
                    <select class="children-age" name="" id="">
                        <option value="-1">-</option>
                        @for($j = 1; $j <= 11; $j++)
                            <option value="{{ $j }}">{{ $j }}</option>
                        @endfor
                    </select>
                @endfor

                <p class="error text-danger fw-bold">{{__('children_age_error')}}</p>
            </div>
            <input type="hidden" id="occupancies">
            <div class="submit-wrapper">
                <input type="submit" class="btn btn-submit" value="{{ __('home_check_availability') }}">
            </div>
        </form>
    @endif
</div>
@endif
