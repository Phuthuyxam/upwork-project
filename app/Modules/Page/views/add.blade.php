@extends('backend.default')
@section('title')
    Add Page
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

        .preview-image,
        .preview-image-multiple .items{
            position: relative;
            overflow: hidden;
            /*width: 50%;*/
        }
        .preview-image-multiple {
            margin-bottom: 1rem;
        }

        .preview-image-multiple .items {
            padding: 0 10px;
        }
        .preview-image-multiple {
            display: flex;
            align-items: center;
        }
        .preview-image .close,
        .preview-image-multiple .items .close{
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

        .preview-image-multiple .items .close {
            top: 0;
            right: 0;
        }

        .preview-image .close i {
            font-size: 14px;
            line-height: .4;
        }

        .action-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .action-wrapper .btn-add {
            margin-right: 10px;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Add Page</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="alert alert-danger alert-common" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Some fields need to required. Please check it again !
            </div>
            <form action="{{ route('page.add') }}" id="add-form" method="post" role="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" id="commonTab">
                                        <a class="nav-link active" id="commonTab" data-toggle="tab" href="#common" role="tab">Common</a>
                                    </li>
                                    <li class="nav-item" id="customTab" style="display: none">
                                        <a class="nav-link " data-toggle="tab" href="#slide" role="tab">Custom Setting</a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    @csrf
                                    <div class="tab-pane active p-3" id="common" role="tabpanel">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control required" name="post_title" id="title"
                                                   placeholder="Title"
                                                   value="{{ old('post_title') }}">
                                            <p style="font-style: italic; font-size: 12px">The name is how it appears on your
                                                website</p>
                                            <p class="text-danger error-message" style="font-weight: bold" id="title-error">
                                                @error('post_title')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" class="form-control required" name="post_name" id="slug"
                                                   placeholder="Slug"
                                                   value="{{ old('post_name') }}">
                                            <p style="font-style: italic; font-size: 12px">The "slug" is the URL-friendly of the
                                                name. It is usually all lower case and contains only letters, numbers, and
                                                hyphens and must be unique</p>
                                            <p class="text-danger error-message" style="font-weight: bold" id="slug-error">
                                                @error('post_name')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="excerpt">Post excerpt</label>
                                            <textarea type="text" class="form-control" name="post_excerpt" id="excerpt" placeholder="Excerpt" rows="8">{{ old('post_excerpt') }}</textarea>
                                            <p class="text-danger error-message" style="font-weight: bold" id="excerpt-error">
                                                @error('post_title')
                                                {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Content</label>
                                            <div class="editor-wrapper">
                                                <textarea name="post_content" id="description" class="form-control"
                                                          style="width: 100%; height: 90px"
                                                          placeholder="Description"></textarea>
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
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 100px">Desktop</th>
                                                    <td>
{{--                                                        <div class="preview-image">--}}
{{--                                                            <div class="close">--}}
{{--                                                                <i class="dripicons-cross"></i>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <input type="file" style="padding: 3px 5px; overflow: hidden"--}}
{{--                                                               class="form-control required banner-image"--}}
{{--                                                               name="files[]">--}}

                                                        {!!  renderMediaManage('files[]') !!}

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
                                                        {!!  renderMediaManage('files[]') !!}
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
                                                        {!!  renderMediaManage('files[]') !!}
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

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <h5 class="card-header mt-0 font-size-16">Template</h5>
                            <div class="card-body">
                                <select name="template" class="form-control" id="template">
                                    @foreach(\App\Core\Glosary\PageTemplateConfigs::getAll() as $value)
                                        <option value="{{ $value['VALUE'] }}">{{ $value['NAME'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="card-footer" style="display: flex; align-items: center; justify-content: space-between">
                                <input type="hidden" id="publishStatus" name="status">
                                <button type="submit" class="btn btn-info btn-draft waves-effect waves-light">Save Draft</button>
                                <button type="submit" class="btn btn-primary btn-submit waves-effect waves-light">Publish</button>
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

            $('#template').on('change',function (){
                let value = $(this).val();
                $('#loading').show();
                $.ajax({
                    url : '{{ route('page.template') }}',
                    type : 'POST',
                    dataType: 'html',
                    data : {
                        _token : '{{ csrf_token() }}',
                        template : value,
                    },
                    success : function (response){
                        $('#loading').hide();
                        if (response) {
                            $('#slide').empty();
                            $('#slide').append(response);
                            $('#customTab').show();
                        }
                    },
                    error : function (e) {
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

            $('#excerpt').on('change',function () {
                let val = $(this).val();
                if (val.trim() === '') {
                    $(this).addClass('error');
                    $('#excerpt-error').text('This field cannot be null');
                }else{
                    $(this).removeClass('error');
                    $('#excerpt-error').text('');
                }
            })
            // Validate File Input
            $('body').on('change',".banner-image",function () {
                let val = $(this).val();
                if (val) {
                    if (validateFileUpload(this)) {
                        readURL(this, $(this).parent().find('.preview-image'));
                        $(this).removeClass('error');
                        $(this).parents('td').find('.error-message').text('');
                        $(this).removeClass('required');
                        if (!$(this).hasClass('multiple')) {
                            $(this).hide();
                        }
                    } else {
                        $(this).parents('td').find('.error-message').text('File must be JPG, GIF or PNG, less than 2MB');
                        $(this).parent().find('.preview-image img').remove();
                        $(this).val('');
                        $(this).addClass('error');
                    }
                } else {
                    $(this).parents('td').find('.error-message').text('This field cannot be null');
                    $(this).removeClass('error');
                    $(this).parent().find('.preview-image img').remove();
                }
            });

            $('body').on('change','.banner-image-multiple',function (){
                let val = $(this).val();
                if (val) {
                    if (validateFileUpload(this)) {
                        readURLMultiple(this,$(this).parent().find('.preview-image-multiple'));
                        $(this).removeClass('error');
                        $(this).removeClass('required');
                        $(this).parents('td').find('.error-message').text('');

                        let count = $(this).parent().find('.number-image').val() === "" ? 0 :parseInt($(this).parent().find('.number-image').val());
                        count = $(this).prop('files').length;
                        $(this).parent().find('.number-image').val(count);
                    } else{
                        $(this).parents('td').find('.error-message').text('File must be JPG, GIF or PNG, less than 2MB. Please choose again');
                        $(this).val('');
                        $(this).addClass('error');
                        $(this).addClass('required');
                        $(this).parent().find('.preview-image-multiple').empty();
                        $(this).parent().find('.number-image').val(0);
                    }
                }else{
                    $(this).parents('td').find('.error-message').text('This field cannot be null');
                    $(this).addClass('error');
                    $(this).addClass('required');
                    $(this).parent().find('.preview-image-multiple').empty();
                    $(this).parent().find('.number-image').val(0);
                }
            })


            $('#tax').on('change',function () {
                if ($(this).val() == '') {
                    $(this).addClass('error');
                    $(this).parents('.form-group').find('.error-message').text('This field cannot be null');
                }else {
                    $(this).removeClass('error');
                    $(this).parents('.form-group').find('.error-message').text('');
                    $(this).removeClass('required');
                }
            })

            CKEDITOR.instances.description.on('change',function (){
                let value = CKEDITOR.instances.description.getData();

                if (value == '') {
                    $('#description').parents('.form-group').find('.editor-wrapper').addClass('error');
                    $('#description').parents('.form-group').find('.error-message').text('This field cannot be null');
                }else{
                    $('#description').parents('.form-group').find('.editor-wrapper').removeClass('error');
                    $('#description').parents('.form-group').find('.error-message').text('');
                }
            })

            $('body').on('click', '.preview-image .close', function () {
                $(this).parent().find('img').remove();
                $(this).parent().parent().find('input[type=file]').val('');
                $(this).parent().parent().find('input[type=file]').show();

                $(this).parents('td').find('.banner-image').addClass('required');
            })

            $('.btn-submit').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#publishStatus').val(1);
                    $('#add-form').submit();
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops... !',
                        text: 'Some field need to required. Please check it again',
                    });
                }
            })

            // $('body').on('change','.required',function (){
            //     let value = $(this).val();
            //     if (value.trim() === '') {
            //         $(this).addClass('error');
            //         $(this).parent().find('.error-message').text('This field cannot be null');
            //     }else{
            //         $(this).removeClass('error');
            //         $(this).parent().find('.error-message').text('');
            //     }
            // })

            $('.btn-draft').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#publishStatus').val(0);
                    $('#add-form').submit();
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops... !',
                        text: 'Some field need to required. Please check it again',
                    });
                }
            })
        })


        function checkRequired(formId) {
            let valid = true;
            $('#' + formId).find('.required').each(function () {
                console.log(this);
                if ($(this).val().trim() === '') {
                    $(this).addClass('error');
                    $(this).parent().find('.error-message').text('This field cannot be null');
                    valid = false;
                } else {
                    $(this).removeClass('error');
                    $(this).parent().find('.error-message').text('This field cannot be null');
                }
            })
            // if (CKEDITOR.instances.description.getData() == '') {
            //     $('#description').parents('.form-group').find('.editor-wrapper').addClass('error');
            //     $('#description').parents('.form-group').find('.error-message').text('This field cannot be null');
            //     valid = false;
            // }else{
            //     $('#description').parents('.form-group').find('.editor-wrapper').removeClass('error');
            //     $('#description').parents('.form-group').find('.error-message').text('');
            // }
            return valid;
        }

        let rowCount = 1;
        $('body').on('click','.btn-add-type',function (e){
            e.preventDefault();
            let row = $(this).parents('tr').clone();
            row.find('.action-wrapper').empty();
            row.find('.action-wrapper').append('<button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>');
            row.find('.preview-image img').remove();
            row.find('.banner-image').val('');
            row.find('.banner-image').show();
            row.find('textarea').val('');

            // multiple image
            rowCount = rowCount + 1;
            row.find('.banner-image-multiple').val('');
            row.find('.banner-image-multiple').attr('name','row'+rowCount+'[]');
            row.find('.preview-image-multiple').empty();
            row.find('.number-image').val(0);


            $(this).parents('tbody').append(row);

            let count = parseInt($(this).parents('.section').find('.item-count').val());
            count = count + 1;
            $(this).parents('.section').find('.item-count').val(count);
        })
        $('body').on('click','.btn-delete-type',function (e){
            e.preventDefault();
            let count = parseInt($(this).parents('.section').find('.item-count').val());
            count = count - 1;
            $(this).parents('.section').find('.item-count').val(count);
            $(this).parents('tr').remove();
        })
    </script>
@endsection
