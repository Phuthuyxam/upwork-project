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
        @if($currentLanguage == 'ar/')
            input,textarea {
            text-align: right;
        }
        @endif
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('backend.elements.languages')
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}

                <div class="row">

                    <div class="col-8">
                        <div class="card">
                            <form action="{{ route('option.save', ['key' => $key]) }}" method="POST" id="save_option">
                                <div class="card-body">
                                    @csrf
                                    @include('Setting::elements.'.$key)
                                </div>
                                <input type="hidden" name="translation" id="translation_mode">
                            </form>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">

                            <div class="card-footer">
                                <div class="submit-section">
                                    <div class="form-group mb-0">

                                        <div>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" id="ptx-save-btn">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        Swal.fire({
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $('#translation_mode').val(lanCode);
                $('#ptx-save-btn').text("Publish with "+display);

                if (lanCode == 'en') {
                    $('body').find('input').css('text-align','left');
                    $('body').find('textarea').css('text-align','left');
                }else{
                    $('body').find('input').css('text-align','right');
                    $('body').find('textarea').css('text-align','right');
                }
            }
        })
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

        $('#ptx-save-btn').click(function (e) {
            e.preventDefault();
            $('#save_option').submit();
        })
    </script>

@endsection
