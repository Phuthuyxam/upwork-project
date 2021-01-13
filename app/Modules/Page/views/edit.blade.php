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
            /*width: 50%;*/
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
        .action-wrapper button{
            display: block;
            margin-bottom: 10px;
        }
        /*.action-wrapper {*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*    justify-content: space-between;*/
        /*}*/

        /*.action-wrapper .btn-add {*/
        /*    margin-right: 10px;*/
        /*}*/

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
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Edit Page</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
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
                                        @if ($result['page_template'] == \App\Core\Glosary\PageTemplateConfigs::HOTEL['VALUE']) style="display: none" @endif>
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
                                            <label for="excerpt">Title</label>
                                            <input type="text" class="form-control required" name="post_excerpt"
                                                   id="excerpt"
                                                   placeholder="Excerpt"
                                                   value="{{ old('post_excerpt') ? old('post_excerpt') : $result['post_excerpt'] }}">
                                            <p class="text-danger error-message" style="font-weight: bold"
                                               id="excerpt-error">
                                                @error('post_excerpt')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
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
{{--                                                        <div class="preview-image">--}}
{{--                                                            <div--}}
{{--                                                                class="close  @if($banner[0] == '') {{ 'deleted' }} @endif">--}}
{{--                                                                <i class="dripicons-cross"></i>--}}
{{--                                                            </div>--}}
{{--                                                            <img src="{{ asset($banner[0]) }}" style="width: 100%"--}}
{{--                                                                 alt="">--}}
{{--                                                        </div>--}}
{{--                                                        <input type="file" style="padding: 3px 5px; overflow: hidden"--}}
{{--                                                               class="form-control banner-image @if($banner[0] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"--}}
{{--                                                               name="files[]">--}}
{{--                                                        <input type="hidden" class="banner-link" name="banners[]"--}}
{{--                                                               data-type="{{ \App\Core\Glosary\MetaKey::BANNER['VALUE'] }}"--}}
{{--                                                               value="{{ $banner[0] }}">--}}

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
{{--                                                        <div class="preview-image">--}}
{{--                                                            <div--}}
{{--                                                                class="close  @if($banner[1] == '') {{ 'deleted' }} @endif">--}}
{{--                                                                <i class="dripicons-cross"></i>--}}
{{--                                                            </div>--}}
{{--                                                            <img src="{{ asset($banner[1]) }}" style="width: 100%"--}}
{{--                                                                 alt="">--}}
{{--                                                        </div>--}}
{{--                                                        <input type="file" style="padding: 3px 5px; overflow: hidden"--}}
{{--                                                               class="form-control banner-image @if($banner[1] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"--}}
{{--                                                               name="files[]">--}}
{{--                                                        <input type="hidden" class="banner-link" name="banners[]"--}}
{{--                                                               data-type="{{ \App\Core\Glosary\MetaKey::BANNER['VALUE'] }}"--}}
{{--                                                               value="{{ $banner[1] }}">--}}
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
{{--                                                        <div class="preview-image">--}}
{{--                                                            <div--}}
{{--                                                                class="close  @if($banner[2] == '') {{ 'deleted' }} @endif">--}}
{{--                                                                <i class="dripicons-cross"></i>--}}
{{--                                                            </div>--}}
{{--                                                            <img src="{{ asset($banner[2]) }}" style="width: 100%"--}}
{{--                                                                 alt="">--}}
{{--                                                        </div>--}}
{{--                                                        <input type="file" style="padding: 3px 5px; overflow: hidden"--}}
{{--                                                               class="form-control banner-image @if($banner[2] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"--}}
{{--                                                               name="files[]">--}}
{{--                                                        <input type="hidden" class="banner-link" name="banners[]"--}}
{{--                                                               data-type="{{ \App\Core\Glosary\MetaKey::BANNER['VALUE'] }}"--}}
{{--                                                               value="{{ $banner[2] }}">--}}
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
                                        @if(isset($result[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']]) && !empty($result[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']]))
                                            @if($result['page_template'] == \App\Core\Glosary\PageTemplateConfigs::SERVICE['VALUE'])
                                                @include('Page::elements.service',
                                                        [
                                                        'serviceItem' => $result[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']]
                                                        ])
                                            @endif
                                        @endif
                                        @if(isset($result[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']])
                                                    && !empty($result[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']])
                                                    && isset($result[\App\Core\Glosary\MetaKey::IMAGE_ITEM['NAME']])
                                                    && !empty($result[\App\Core\Glosary\MetaKey::INDEX_COMPLETE_ITEM['NAME']])
                                                    && isset($result[\App\Core\Glosary\MetaKey::INDEX_COMPLETE_ITEM['NAME']])
                                                    && !empty($result[\App\Core\Glosary\MetaKey::IMAGE_ITEM['NAME']]))
                                            @if($result['page_template'] == \App\Core\Glosary\PageTemplateConfigs::ABOUT['VALUE'])
                                                @include('Page::elements.about',
                                                        [
                                                            'indexItem' => $result[\App\Core\Glosary\MetaKey::INDEX_COMPLETE_ITEM['NAME']],
                                                            'completeItem' => $result[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']],
                                                            'imageItem' => $result[\App\Core\Glosary\MetaKey::IMAGE_ITEM['NAME']]
                                                        ])
                                            @endif
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
                                <button type="submit" class="btn btn-info btn-draft waves-effect waves-light">Save
                                    Draft
                                </button>
                                <button type="submit" class="btn btn-primary btn-submit waves-effect waves-light">
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
                        if (response) {
                            $('#slide').empty();
                            $('#slide').append(response);
                            $('#customTab').show();
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
            // Validate File Input
            $('body').on('change', ".banner-image", function () {
                let val = $(this).val();
                if (val) {
                    if (validateFileUpload(val)) {
                        readURL(this, $(this).parent().find('.preview-image'));
                        $(this).removeClass('error');
                        $(this).parents('td').find('.error-message').text('');
                        $(this).removeClass('required');
                        $(this).hide();
                    } else {
                        $(this).parents('td').find('.error-message').text('File extension is not allow');
                        $(this).parent().find('.preview-image img').remove();
                        $(this).addClass('error');
                    }
                } else {
                    $(this).parents('td').find('.error-message').text('This field cannot be null');
                    $(this).removeClass('error');
                    $(this).parent().find('.preview-image img').remove();
                }
            });

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

            CKEDITOR.instances.description.on('change', function () {
                let value = CKEDITOR.instances.description.getData();

                if (value == '') {
                    $('#description').parents('.form-group').find('.editor-wrapper').addClass('error');
                    $('#description').parents('.form-group').find('.error-message').text('This field cannot be null');
                } else {
                    $('#description').parents('.form-group').find('.editor-wrapper').removeClass('error');
                    $('#description').parents('.form-group').find('.error-message').text('');
                }
            })

            $('body').on('click', '.preview-image .close', function () {
                $(this).parent().find('img').remove();
                $(this).parent().parent().find('input[type=file]').val('');
                $(this).parent().parent().find('input[type=file]').show();
                $(this).parent().parent().find('.banner-link').val('');
                $(this).parents('td').find('.banner-image').addClass('required');
            })

            $('.btn-submit').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#publishStatus').val(1);
                    $('#add-form').submit();
                    // $('#commonTab').css('background', '');
                } else {
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops... !',
                        text: 'Some field need to required. Please check it again',
                    });
                    // $('#commonTab').css('background', '#FF7575');
                }
            })

            $('.btn-draft').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#publishStatus').val(0);
                    $('#add-form').submit();
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

        function readURL(input, element) {
            if (input.files && input.files[0]) {
                element.find('img').remove();
                let reader = new FileReader();
                let name = input.files[0].name;
                reader.onload = function (e) {

                    let html = '<img id="image" style="width: 100%" src="' + e.target.result + '" title="' + name + '" alt="your image" />';
                    element.append(html);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function checkRequired(formId) {
            let valid = true;
            $('#' + formId).find('.required').each(function () {
                if ($(this).val().trim() === '') {
                    $(this).addClass('error');
                    $(this).parent().find('.error-message').text('This field cannot be null');
                    valid = false;
                } else {
                    $(this).removeClass('error');
                    $(this).parent().find('.error-message').text('');
                }
            })
            if (CKEDITOR.instances.description.getData() == '') {
                $('#description').parents('.form-group').find('.editor-wrapper').addClass('error');
                $('#description').parents('.form-group').find('.error-message').text('This field cannot be null');
                valid = false;
            } else {
                $('#description').parents('.form-group').find('.editor-wrapper').removeClass('error');
                $('#description').parents('.form-group').find('.error-message').text('');
            }
            return valid;
        }

        $('body').on('click', '.btn-add-type', function (e) {
            e.preventDefault();
            let row = $(this).parents('tr').clone();
            row.find('.action-wrapper').empty();
            row.find('.action-wrapper').append('<button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>');
            row.find('.preview-image img').remove();
            row.find('.banner-image').val('');
            row.find('.banner-image').show();
            row.find('.banner-image').removeClass('hidden');
            row.find('.banner-image').addClass('required');
            row.find('.banner-link').val('');
            row.find('textarea').val('');
            row.find('.home-slider-image').val('');
            row.find('.image-preview-container').html("");
            $(this).parents('tbody').append(row);

            row.find('.banner-image-multiple').val('');

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

        $('body').on('change','.banner-image-multiple',function (){
            $(this).parent().find('.banner-link').val('');

        })
    </script>
@endsection

