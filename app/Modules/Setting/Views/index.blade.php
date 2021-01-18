@extends('backend.default')
@section('style')
    <style>
        .error {
            border: 1px solid red;
        }
        .form-group p {
            margin-bottom: 0;
        }
        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }
        .action-wrapper .btn-add-type{
            margin-bottom: 1rem;
        }
        .preview-image {
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
            background: #ccc;
            width: 40%;
        }
        .preview-image .close {
            position: absolute;
            top: 5px;
            left: 5px;
            cursor: pointer;
            background: #9C9C9C;
            border-radius: 100%;
            opacity: 1;
            text-shadow: unset;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .preview-image .close i {
            font-size: 14px;
            line-height: .4;
        }
        .list-option {
            margin: 20px 0px;
            list-style: none;
            padding-left: 0px;
        }
        .list-option li {

            border: solid thin #0F355E;
        }
        .list-option .active {
            background: #0F355E;
            color: #ffffff;
        }
        .list-option a {
            padding: 10px;
            display: block;
            color: #0a0a0a;
        }
        .list-option .active a {
            color: #ffffff;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('backend.elements.languages')
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <form action="{{ route('option.save', ['key' => $key]) }}" method="POST">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                @csrf
                                @include('Setting::elements.'.$key)
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <h4 class="card-title card-header">Edit Option</h4>
                            <div class="card-body">
                                <div class="tab-heading" style="display: flex; justify-content: space-between;align-items: center">
                                    @php
                                        $languages = \App\Core\Glosary\LocationConfigs::getAll();
                                        $currentLang = app()->getLocale();
                                    @endphp
                                    @if(isset($languages) && !empty($languages))

                                        <div class="tab-translate">
                                            <b><i class="dripicons-flag"></i> Make translation</b>
                                            <select id="make-translation">
                                                <option value="0">---choose language---</option>
                                                @foreach($languages as $lan)
                                                    @if($lan['VALUE'] != $currentLang)
                                                        <option value="{{ $lan['VALUE'] }}" data-display="{{ $lan['DISPLAY'] }}">
                                                            {{ $lan['DISPLAY'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="submit-section">
                                    <div class="form-group mb-0">
                                        <input type="hidden" name="translation" id="translation_mode">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="ptx-save-btn">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </form>
                        {{-- SEO form for home page --}}
                        @if($key == \App\Core\Glosary\OptionMetaKey::HOME['VALUE'])
                             @include('Seo::seo',['objectId' => \App\Core\Glosary\SeoConfigs::SEOPAGEFIXED['HOMEPAGE']['FIXID'] , 'seoType' => \App\Core\Glosary\SeoConfigs::SEOTYPE['SINGLE']['KEY'] ])
                        @endif
                    </div>
                </div>
{{--            </form>--}}
        </div>
    </div>
@endsection
@section('script')
    <script>
    $('body').on('click','.btn-add-type',function (e){
        e.preventDefault();
        let row = $(this).parents('tr').clone();
        row.find('.action-wrapper').empty();
        row.find('.action-wrapper').append('<button type="button" class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button><button type="button" class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>');
        row.find('.option-menu-title').val('');
        row.find('.option-menu-url').val('');
        row.find('.option-home-slider-desc').val('');
        row.find('.option-home-slider-url').val('');
        row.find('.home-slider-image').val('');
        row.find('.image-preview-container').html("");
        row.find('.home_brand_url').val('');
        let count = row.find('.counter').text();
        count = parseInt(count) + 1;
        row.find('.counter').text(count);
        $(this).parents('tbody').append(row);
    })
    $('body').on('click','.btn-delete-type',function (e){
        e.preventDefault();
        $(this).parents('tr').remove();
    })

    $('#make-translation').change(function (e){
        e.preventDefault();
        let lanCode = $(this).val();
        if(lanCode === "0") {
            $('#ptx-save-btn').text("Save");
            $('#translation_mode').val("");
            return
        }
        let display = $("#make-translation option:selected").data('display');
        let text = "Are you sure make a translation to " + display + " ? After confirm you will complete with save button";
        var r = confirm(text);
        if (r == true) {
            $('#translation_mode').val(lanCode);
            $('#ptx-save-btn').text("Save with "+display);
            $('html, body').animate({ scrollTop: $('#ptx-save-btn').offset().top }, 'slow');
        }
    });

    $('#ptx-save-btn').click(function (e) {
        e.preventDefault();
        let valid = true;
        if ($('#menu-table').length) {
            e.preventDefault();
            $('#menu-table').find('tr').each(function (i) {
                if ($(this).find('input.option-menu-title').val() === '' && i < 6) {
                    valid = false;
                }

            })

            if (valid) {
                $('form').submit();
            }else{
                Swal.fire({
                    type: 'warning',
                    text: 'Please insert at least 5 elements',
                })
            }
        }else{
            $('form').submit();
        }
    })
    </script>

@endsection
