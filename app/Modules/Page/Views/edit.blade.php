@extends('backend.default')
@section('title')
    Edit Page
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
            position: relative;
            overflow: hidden;
            margin-bottom: 1rem;
            /*width: 50%;*/
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
        .action-wrapper button{
            display: block;
            margin-bottom: 10px;
        }

        .hidden {
            display: none;
        }
        .preview-image-multiple .items {
            padding: 0 10px;
        }
        .preview-image-multiple {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .image-items .preview-image {
            width: 20% !important;
        }
        .btn-add-child {
            margin-bottom: 1rem;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Edit Page</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}

            @if(isset($translationRecord) && $translationRecord != false)
                <div class="card">
                    <div class="card-body">
                        <div class="tab-translate">
                            <a href="{{ $translationRecord['url'] }}"><i class="dripicons-flag"></i> Go to translation record {{ \App\Core\Glosary\LocationConfigs::getLanguageByCode($translationRecord['lang_code'])['DISPLAY'] }}</a>
                        </div>
                    </div>
                </div>
            @else

                @php
                    $languages = \App\Core\Glosary\LocationConfigs::getAll();
                    $currentLang = app()->getLocale();

                @endphp
                @if(isset($languages) && !empty($languages))
                    <div class="card">
                        <div class="card-body">
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
                        </div>
                    </div>
                @endif

            @endif





            <div class="alert alert-danger alert-common" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                Some fields need to required. Please check it again !
            </div>
            <form action="{{ route('page.edit',$result['id']) }}" id="add-form" method="post" role="form"
                  enctype="multipart/form-data">
                <div class="row">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" id="commonTab">
                                        <a class="nav-link active" id="commonTab" data-toggle="tab" href="#common"
                                           role="tab">Common</a>
                                    </li>
                                    <li class="nav-item" id="customTab"
                                        @if ($result['page_template'] == \App\Core\Glosary\PageTemplateConfigs::HOTEL['VALUE']
                                            || $result['page_template'] == \App\Core\Glosary\PageTemplateConfigs::DEFAULT['VALUE'] ) style="display: none" @endif>
                                        <a class="nav-link " data-toggle="tab" href="#slide" role="tab">Custom
                                            Setting</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    @csrf
                                    <div class="tab-pane active p-3" id="common" role="tabpanel">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control required" name="post_title"
                                                   id="title"
                                                   placeholder="Title"
                                                   value="{{ old('post_title') ? old('post_title') : $result['post_title']  }}">
                                            <p style="font-style: italic; font-size: 12px">The name is how it appears on
                                                your
                                                website</p>
                                            <p class="text-danger error-message" style="font-weight: bold"
                                               id="title-error">
                                                @error('post_title')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                            <a href="{{ route('detail',$result['post_name']) }}" style="font-size: 13px" target="_blank">{{ urldecode(route('detail',$result['post_name'])) }}</a>
                                        </div>

                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" class="form-control required" name="post_name" id="slug"
                                                   placeholder="Slug"
                                                   value="{{ old('post_name') ? old('post_name') : $result['post_name'] }}">
                                            <p style="font-style: italic; font-size: 12px">The "slug" is the
                                                URL-friendly of the
                                                name. It is usually all lower case and contains only letters, numbers,
                                                and
                                                hyphens and must be unique</p>
                                            <p class="text-danger error-message" style="font-weight: bold"
                                               id="slug-error">
                                                @error('post_name')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="excerpt">Excerpt</label>
                                            <textarea type="text" class="form-control required" name="post_excerpt" id="excerpt" placeholder="Excerpt" rows="8">{{ old('post_excerpt') ? old('post_excerpt') : $result['post_excerpt'] }}</textarea>
                                            <p class="text-danger error-message" style="font-weight: bold" id="excerpt-error">
                                                @error('post_excerpt')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Content</label>
                                            <div class="editor-wrapper">
                                                <textarea name="post_content" id="description" class="form-control"
                                                          style="width: 100%; height: 90px"
                                                          placeholder="Description">{{ old('post_content') ? old('post_content') : $result['post_content'] }}</textarea>
                                            </div>
                                            <p class="text-danger error-message" style="font-weight: bold"
                                               id="description-error">
                                                @error('post_content')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">Banner</label>
                                            @php
                                                $banner = json_decode($result[\App\Core\Glosary\MetaKey::BANNER['NAME']])
                                            @endphp
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 100px">Desktop</th>
                                                    <td>
                                                        {!!  renderMediaManage('files[]', $banner[0]) !!}
                                                        <p class="text-danger error-message" style="font-weight: bold">
                                                            @error('files')
                                                            {{ $message }}
                                                            @enderror
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 100px">Tablet</th>
                                                    <td>
                                                        {!!  renderMediaManage('files[]', $banner[1]) !!}
                                                        <p class="text-danger error-message" style="font-weight: bold">
                                                            @error('files')
                                                            {{ $message }}
                                                            @enderror
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 100px">Mobile</th>
                                                    <td>
                                                        {!!  renderMediaManage('files[]', $banner[2]) !!}
                                                        <p class="text-danger error-message" style="font-weight: bold">
                                                            @error('files')
                                                            {{ $message }}
                                                            @enderror
                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-3" id="slide" role="tabpanel">
                                        @if($result['page_template'] == \App\Core\Glosary\PageTemplateConfigs::SERVICE['VALUE'])
                                                @include('Page::elements.service',
                                                        ['serviceItem' => $result[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']]])
                                        @endif
                                        @if($result['page_template'] == \App\Core\Glosary\PageTemplateConfigs::ABOUT['VALUE'])
                                                @include('Page::elements.about', [ 'imageMap' => $imageMap , 'itemMap' => $itemMap ])
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <h5 class="card-header mt-0 font-size-16">Template</h5>
                            <div class="card-body">
                                <select name="template" data-id="{{ $result['id'] }}" class="form-control"
                                        id="template">
                                    @foreach(\App\Core\Glosary\PageTemplateConfigs::getAll() as $value)
                                        <option value="{{ $value['VALUE'] }}"
                                                @if($result['page_template'] == $value['VALUE']) selected @endif>{{ $value['NAME'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="card-footer"
                                 style="display: flex; align-items: center; justify-content: space-between">
                                <input type="hidden" id="publishStatus" name="status">
                                <input type="hidden" name="translation" id="translation_mode">
                                <button type="submit" class="btn btn-info btn-draft waves-effect waves-light" id="ptx-save-btn-draf">Save
                                    Draft
                                </button>
                                <button type="submit" class="btn btn-primary btn-submit waves-effect waves-light" id="ptx-save-btn">
                                    Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('extension_script')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('script')
    <script>
        const maxFileSize = '{{ \App\Core\Glosary\MaxFileSize::IMAGE['VALUE'] }}';
        let currentTemplate = {{ $result[\App\Core\Glosary\MetaKey::PAGE_TEMPLATE['NAME']] }};
        const defaultTemplate = {{ \App\Core\Glosary\PageTemplateConfigs::HOTEL['VALUE'] }};
        {{--const slugs = JSON.parse('{!! json_encode($slugs) !!}')--}}
        CKEDITOR.replace('description', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
        $(document).ready(function () {

            $('#template').on('change', function () {
                let value = $(this).val();
                let postId = $(this).data('id');
                $('#loading').show();
                $.ajax({
                    url: '{{ route('page.template') }}',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        _token: '{{ csrf_token() }}',
                        template: value,
                        postId: postId
                    },
                    success: function (response) {
                        $('#loading').hide();
                        if (response != 'default') {
                            $('#slide').empty();
                            $('#slide').append(response);
                            $('#customTab').show();
                        }else{
                            $('#customTab').hide();
                            $('#slide').empty();
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                })
            })

            $('#title').on('change', function () {
                let val = $(this).val();
                $('#slug').val(changeToSlug(val));
                if (val.trim() !== '') {
                    $(this).removeClass('error required');
                    $('#title-error').text("");
                    $('#slug').removeClass('error required');
                    $('#slug-error').text('');
                } else {
                    $(this).addClass('error required');
                    $('#title-error').text("This field cannot be null");
                    $('#slug').addClass('required');
                }
            })

            $('#slug').on('change', function () {
                let val = $(this).val();
                if (val.trim() === '') {
                    $(this).val(changeToSlug($('#title').val()));
                    $(this).removeClass('required');
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

            $('#excerpt').on('change', function () {
                let val = $(this).val();
                if (val.trim() === '') {
                    $(this).addClass('error');
                    $('#excerpt-error').text('This field cannot be null');
                } else {
                    $(this).removeClass('error');
                    $('#excerpt-error').text('');
                }
            })

            $('#tax').on('change', function () {
                if ($(this).val() == '') {
                    $(this).addClass('error');
                    $(this).parents('.form-group').find('.error-message').text('This field cannot be null');
                } else {
                    $(this).removeClass('error');
                    $(this).parents('.form-group').find('.error-message').text('');
                    $(this).removeClass('required');
                }
            })

            $('.btn-submit').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    if (parseInt($('#template').val()) !== currentTemplate && currentTemplate != defaultTemplate) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You are changing template! Old data will be lost",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Confirm !'
                        }).then((result) => {
                            if (result.value) {
                                $('#publishStatus').val(1);
                                $('#add-form').submit();
                            }
                        })
                    }else{
                        $('#publishStatus').val(1);
                        $('#add-form').submit();
                    }
                } else {
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops... !',
                        text: 'Some field need to required. Please check it again',
                    });
                }
            })

            $('.btn-draft').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    if (parseInt($('#template').val()) !== currentTemplate && currentTemplate != defaultTemplate) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You are changing template! Old data will be lost",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Confirm !'
                        }).then((result) => {
                            if (result.value) {
                                $('#publishStatus').val(0);
                                $('#add-form').submit();
                            }
                        })
                    }else{
                        $('#publishStatus').val(0);
                        $('#add-form').submit();
                    }
                } else {
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops... !',
                        text: 'Some field need to required. Please check it again',
                    });
                }
            })

            $('body').on('change', '.required', function () {
                let value = $(this).val();
                if (value.trim() === '') {
                    $(this).addClass('error');
                    $(this).parent().find('.error-message').text('This field cannot be null');
                } else {
                    $(this).removeClass('error');
                    $(this).parent().find('.error-message').text('');
                }
            })
        })

        $('body').on('click', '.btn-add-type', function (e) {
            e.preventDefault();
            let row = $(this).closest('tr').clone();
            row.find('.action-wrapper').empty();
            row.find('.action-wrapper').append('<button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>');
            row.find('textarea').val('');
            row.find('.home-slider-image').val('');
            row.find('.image-preview-container').html("");

            if ($(this).hasClass('parent')) {
                row.find('.action-wrapper').empty();
                row.find('.action-wrapper').append('<button class="btn btn-success btn-add-type parent"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete-type parent"><i class="dripicons-minus"></i></button>');
                let imageRow = row.find('.image-items tr').first();
                row.find('.image-items tbody').empty();
                row.find('.image-items tbody').append(imageRow[0].outerHTML);
                row.find('.image-items tbody')
                row.find('.row-item').val(1);
                row.find('.home-slider-image').val('');
            }

            $(this).closest('tbody').append(row);

            let count = parseInt($(this).parents('.section').find('.item-count').val());
            count = count + 1;
            $(this).parents('.section').find('.item-count').val(count);

        })

        $('body').on('click', '.btn-delete-type', function (e) {
            e.preventDefault();

            let count = parseInt($(this).parents('.section').find('.item-count').val());
            count = count - 1;
            $(this).parents('.section').find('.item-count').val(count);

            $(this).parents('tr').remove();
        })

        $('body').on('click', '.btn-add-child', function (e) {
            e.preventDefault();
            let row = $(this).closest('tr').clone();
            row.find('.button-wrapper').empty();
            row.find('.button-wrapper').append('<button class="btn btn-success btn-add-child"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete-child"><i class="dripicons-minus"></i></button>');

            row.find('.image-preview-container').html("");
            $(this).closest('tbody').append(row);
            row.find('.home-slider-image').val('');

            let countItem = parseInt($(this).closest('.image-items').find('.row-item').val());
            countItem = countItem + 1;
            $(this).closest('.image-items').find('.row-item').val(countItem);
        })


        $('body').on('click', '.btn-delete-child', function (e) {
            e.preventDefault();

            let countItem = parseInt($(this).closest('.image-items').find('.row-item').val());
            countItem = countItem - 1;
            $(this).closest('.image-items').find('.row-item').val(countItem);

            $(this).closest('tr').remove();
        })

        function checkRequired(formId) {
            let valid = true;
            $('#' + formId).find('.required').each(function () {
                if ($(this).val().trim() === '') {
                    $(this).addClass('error');
                    $(this).closest('tr').find('.error-message').text('This field cannot be null');
                    valid = false;
                } else {
                    $(this).removeClass('error');
                    $(this).closest('tr').find('.error-message').text('');
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
                    $('#ptx-save-btn-draf').text("Save Draft with "+display);
                }
            })
        });
    </script>
@endsection

