@extends('backend.default')
@section('title')
    Edit Taxonomy
@endsection
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
        .preview-image {
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
            width: 50%;
        }
        .preview-image img{
            width: 100%;
        }
        .preview-image .close {
            position: absolute;
            top: 5px;
            right: 5px;
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
        .hidden {
            display: none;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Edit Category</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        @php
            $languages = \App\Core\Glosary\LocationConfigs::getAll();
            $currentLang = app()->getLocale();

        @endphp
        @if(isset($languages) && !empty($languages))
            <div class="car">
                <div class="card-body">
                    <div class="row" >
                        <div class="tab-translate col-12" style="float: right">
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
                    </div>
                </div>
            </div>
        @endif


        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('taxonomy.edit',$result['id']) }}" id="add-form" method="post" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control required" name="name" id="name" placeholder="Name" value="{{ old('name') ? old('name') : $result['name'] }}">
                            <p style="font-style: italic; font-size: 12px">The name is how it appears on your
                                website</p>
                            <p class="text-danger error-message" style="font-weight: bold"  id="name-error">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control required" name="slug" id="slug" placeholder="Slug" value="{{ old('slug') ? old('slug') : $result['slug'] }}">
                            <p style="font-style: italic; font-size: 12px">The "slug" is the URL-friendly of the
                                name. It is usually all lower case and contains only letters, numbers, and
                                hyphens and must be unique</p>
                            <p class="text-danger error-message" style="font-weight: bold" id="slug-error">
                                @error('slug')
                                {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control required"
                                      style="width: 100%; height: 90px" placeholder="Description" >{{ old('description') ? old('description') : $taxonomy['description'] }}</textarea>
                            <p style="font-style: italic; font-size: 12px">Description for your category.
                                Totally optional</p>
                            <p class="text-danger error-message" style="font-weight: bold" id="description-error" >
                                @error('description')
                                {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <input type="hidden" name="translation" id="translation_mode">
                        <button type="submit" class="btn btn-primary btn-submit" id="ptx-save-btn">Submit</button>
                    </form>
                </div>
            </div>

            <div class="car">
                <div class="card-body row">
                    <div class="col-4">
                        @include('Seo::seo',['objectId' => $result['id'] , 'seoType' => \App\Core\Glosary\SeoConfigs::SEOTYPE['SINGLE']['KEY'] ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const slugs = JSON.parse('{!! json_encode($slugs) !!}');
        $(document).ready(function () {
            // Validate Name
            $('#name').on('change', function () {
                let val = $(this).val();
                $('#slug').val(changeToSlug(val));
                if (val.trim() !== '') {
                    $(this).removeClass('error');
                    $('#name-error').text("");
                    $('#slug').removeClass('error required');
                    $('#slug-error').text('');
                } else {
                    $(this).addClass('error');
                    $('#name-error').text("This field cannot be null");
                    $('#slug').addClass('required');
                }
            })

            $('#slug').on('change', function () {
                let val = $(this).val();
                if (val.trim() === '') {
                    $(this).val(changeToSlug($('#name').val()));
                } else {
                    if (slugs.indexOf(val) >= 0) {
                        $('#slug-error').text('Slug already exist');
                        $(this).addClass('error');
                    } else {
                        $('#slug-error').text('');
                        $(this).removeClass('error');
                    }
                }
            })

            $('#description').on('change', function () {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('error');
                    $('#description-error').text('')
                }
            })

            $('.btn-submit').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#add-form').submit();
                }
            })
        })
        function checkRequired(formId) {
            let valid = true;
            $('#'+formId).find('.required').each(function (){
                if ($(this).val().trim() === '') {
                    $(this).addClass('error');
                    $(this).parents('.form-group').find('.error-message').text('This field cannot be null');
                    valid = false;
                }else{
                    $(this).removeClass('error');
                    $(this).parents('.form-group').find('.error-message').text('');
                }
            })

            return valid;
        }

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
                $('#ptx-save-btn').text("Submit with "+display);
                $('html, body').animate({ scrollTop: ( $('#ptx-save-btn').offset().top - 200 ) }, 'slow');
            }
        });
    </script>
@endsection
