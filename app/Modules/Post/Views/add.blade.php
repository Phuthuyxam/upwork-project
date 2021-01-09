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

        .preview-image {
            position: relative;
            overflow: hidden;
            width: 50%;
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
    <h4 class="page-title font-size-18">Add post</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="alert alert-danger alert-common" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Some fields need to required. Please check it again !
            </div>
            <form action="{{ route('post.add') }}" id="add-form" method="post" role="form" enctype="multipart/form-data">
                <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#common" role="tab">Common</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#slide" role="tab">Slides setting</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#type" role="tab">Rooms Type & Inventory</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Facilities and
                                        Amenities</a>
                                </li>
                            </ul>
                                <div class="tab-content">
                                    @csrf
                                    <div class="tab-pane active p-3" id="common" role="tabpanel">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control required" name="post_title" id="title"
                                                   placeholder="Title"
                                                   value="{{ old('post_name') }}">
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
                                            <label for="file">Banner</label>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th style="vertical-align: middle; width: 100px">Desktop</th>
                                                        <td>
                                                            <div class="preview-image">
                                                                <div class="close">
                                                                    <i class="dripicons-cross"></i>
                                                                </div>
                                                            </div>
                                                            <input type="file" style="padding: 3px 5px; overflow: hidden"
                                                                   class="form-control required banner-image"
                                                                   name="file[]">
                                                            <p class="text-danger error-message" style="font-weight: bold">
                                                                @error('file')
                                                                    {{ $message }}
                                                                @enderror
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="vertical-align: middle; width: 100px">Tablet</th>
                                                        <td>
                                                            <div class="preview-image">
                                                                <div class="close">
                                                                    <i class="dripicons-cross"></i>
                                                                </div>
                                                            </div>
                                                            <input type="file" style="padding: 3px 5px; overflow: hidden"
                                                                   class="form-control required banner-image"
                                                                   name="file[]">
                                                            <p class="text-danger error-message" style="font-weight: bold">
                                                                @error('file')
                                                                {{ $message }}
                                                                @enderror
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="vertical-align: middle; width: 100px">Mobile</th>
                                                        <td>
                                                            <div class="preview-image">
                                                                <div class="close">
                                                                    <i class="dripicons-cross"></i>
                                                                </div>
                                                            </div>
                                                            <input type="file" style="padding: 3px 5px; overflow: hidden"
                                                                   class="form-control required banner-image"
                                                                   name="file[]">
                                                            <p class="text-danger error-message" style="font-weight: bold">
                                                                @error('file')
                                                                {{ $message }}
                                                                @enderror
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
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
                                    </div>
                                    <div class="tab-pane p-3" id="slide" role="tabpanel">
                                        <table class="table-bordered table">
                                            <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="preview-image">
                                                        <div class="close">
                                                            <i class="dripicons-cross"></i>
                                                        </div>
                                                    </div>
                                                    <input type="file" name="images[]" class="input-image">
                                                </td>
                                                <td style="width: 120px; vertical-align: middle">
                                                    <div class="action-wrapper">
                                                        <button class="btn btn-success btn-add"><i class="dripicons-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane p-3" id="type" role="tabpanel">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Rooms type</th>
                                                <th>Inventory</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="room_types[]">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="inventories[]">
                                                </td>
                                                <td style="width: 120px; vertical-align: middle">
                                                    <div class="action-wrapper">
                                                        <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(old('room_types[]') && old('inventories[]'))
                                                @foreach(old('room_types[]') as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="room_types[]" value="{{ $value }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="inventories[]" value="{{ old('inventories[]')[$key] }}">
                                                        </td>
                                                        <td style="width: 120px; vertical-align: middle">
                                                            <div class="action-wrapper">
                                                                <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane p-3" id="settings" role="tabpanel">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Facilities and Amenities</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="facilities[]">
                                                </td>
                                                <td style="width: 120px; vertical-align: middle">
                                                    <div class="action-wrapper">
                                                        <button class="btn btn-success btn-add-facility"><i class="dripicons-plus"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <h5 class="card-header mt-0 font-size-16">Publish</h5>
                        <div class="card-body">
                            <div class="status">
                                <span><i class="dripicons-flag"></i> Status : {{ \App\Core\Glosary\PostStatus::DRAFT['NAME'] }}</span>
                            </div>
                        </div>
                        <div class="card-footer" style="display: flex; align-items: center; justify-content: space-between">
                            <input type="hidden" id="publishStatus" name="status">
                            <button type="submit" class="btn btn-info btn-draft waves-effect waves-light">Save Draft</button>
                            <button type="submit" class="btn btn-primary btn-submit waves-effect waves-light">Publish</button>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header mt-0 font-size-16">Select Category</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <select name="taxonomy" id="tax" class="form-control required">
                                    <option value="">Select Category</option>
                                    @foreach($taxonomy as $value)
                                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger error-message" style="font-weight: bold" id="title-error">
                                    @error('post_title')
                                    {{ $message }}
                                    @enderror
                                </p>
                            </div>

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
        const slugs = JSON.parse('{!! json_encode($slugs) !!}')
        CKEDITOR.replace('description', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
        $(document).ready(function () {
            $('#title').on('change', function () {
                let val = $(this).val();
                $('#slug').val(changeToSlug(val));
                if (val.trim() !== '') {
                    $(this).removeClass('error');
                    $('#title-error').text("");
                    $('#slug').removeClass('error');
                    $('#slug-error').text('');
                    $(this).removeClass('required');
                } else {
                    $(this).addClass('error');
                    $('#title-error').text("This field cannot be null");
                    $(this).addClass('required');
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
            // Validate File Input
            $(".banner-image").change(function () {
                let val = $(this).val();
                if (val) {
                    if (validateFileUpload(val)) {
                        readURL(this, $(this).parent().find('.preview-image'));
                        $(this).removeClass('error');
                        $(this).parents('td').find('.error-message').text('');
                        $(this).removeClass('required');
                        $(this).hide();
                    } else {
                        $('#file-error').text('File extension is not allow');
                        $('.preview-image img').remove();
                        $(this).addClass('error');
                    }
                } else {
                    $('#file-error').text('This field cannot be null');
                    $(this).removeClass('error');
                    $('.preview-image img').remove();
                }
            });

            $('#tax').on('change',function () {
                if ($(this).val() == '') {
                    $(this).addClass('error');
                    $(this).parents('.form-group').find('.error-message').text('This field cannot be null');
                }else {
                    $(this).removeClass('error');
                    $(this).parents('.form-group').find('.error-message').text('');
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
                    $('.alert-common').hide();
                }else{
                    $('.alert-common').show();
                }
            })

            $('.btn-draft').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#publishStatus').val(0);
                    $('#add-form').submit();
                    $('.alert-common').hide();
                }else{
                    $('.alert-common').show();
                }
            })
        })

        function readURL(input, element) {
            if (input.files && input.files[0]) {
                element.find('img').remove();
                let reader = new FileReader();
                let name = input.files[0].name;
                reader.onload = function (e) {

                    let html = '<img id="image" style="width: 100%" src="' + e.target.result + '" title="'+name+'" alt="your image" />';
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
                    $(this).parent().find('.error-message').text('This field cannot be null');
                }
            })
            if (CKEDITOR.instances.description.getData() == '') {
                $('#description').parents('.form-group').find('.editor-wrapper').addClass('error');
                $('#description').parents('.form-group').find('.error-message').text('This field cannot be null');
                valid = false;
            }else{
                $('#description').parents('.form-group').find('.editor-wrapper').removeClass('error');
                $('#description').parents('.form-group').find('.error-message').text('');
            }
            return valid;
        }

        var html = '<tr>\n' +
            '<td>' +
            ' <div class="preview-image">\n' +
            ' <div class="close">\n' +
            ' <i class="dripicons-cross"></i>\n' +
            '  </div>\n' +
            ' </div>\n' +
            '<input type="file" name="images[]" class="input-image">\n' +
            '</td>\n' +
            '<td style="width: 120px;vertical-align: middle">\n' +
            '<div class="action-wrapper">\n' +
            '<button class="btn btn-success btn-add"><i class="dripicons-plus"></i></button>\n' +
            '<button class="btn btn-danger btn-delete"><i class="dripicons-minus"></i></button>\n' +
            '</div>\n' +
            '</td>\n' +
            ' </tr>'
        $('body').on('click', '.btn-add', function (e) {
            e.preventDefault();
            $(this).parents('tbody').append(html);
        })
        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        })

        $('body').on('change', '.input-image', function () {
            let val = $(this).val();
            if (val) {
                if (validateFileUpload(val)) {
                    readURL(this, $(this).parent().find('.preview-image'));
                    $('#file-error').text('');
                } else {
                    $('#file-error').text('File extension is not allow');
                    $('.preview-image img').remove();
                    $(this).addClass('error');
                }
            } else {
                $('#file-error').text('This field cannot be null');
                $(this).removeClass('error');
                $('.preview-image img').remove();
            }
        })

        var type = `<tr>
                        <td>
                            <input type="text" class="form-control" name="room_types[]">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="inventories[]">
                        </td>
                        <td style="width: 120px;vertical-align: middle">
                            <div class="action-wrapper">
                                <button class="btn btn-success btn-add-type"><i class="dripicons-plus"></i></button>
                                <button class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>
                            </div>
                        </td>
                    </tr>`;
        $('body').on('click', '.btn-add-type', function (e) {
            e.preventDefault();
            $(this).parents('tbody').append(type);
        })
        $('body').on('click', '.btn-delete-type', function (e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        })

        var facility = `<tr>
                        <td>
                            <input type="text" class="form-control" name="facilities[]">
                        </td>
                        <td style="width: 120px;vertical-align: middle">
                            <div class="action-wrapper">
                                <button class="btn btn-success btn-add-facility"><i class="dripicons-plus"></i></button>
                                <button class="btn btn-danger btn-delete-facility"><i class="dripicons-minus"></i></button>
                            </div>
                        </td>
                    </tr>`;
        $('body').on('click', '.btn-add-facility', function (e) {
            e.preventDefault();
            $(this).parents('tbody').append(facility);
        })
        $('body').on('click', '.btn-delete-facility', function (e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        })
    </script>
@endsection
