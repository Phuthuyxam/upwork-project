@extends('backend.default')
@section('title')
    Add Hotel
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
    <h4 class="page-title font-size-18">Add Hotel</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="alert alert-danger alert-common" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Some fields need to required. Please check it again !
            </div>
            <form action="{{ route('post.add',\App\Core\Glosary\PostType::POST['VALUE']) }}" id="add-form" method="post" role="form" enctype="multipart/form-data">
                <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="commonTab" data-toggle="tab" href="#common" role="tab">Common</a>
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
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#map" role="tab"> Map settings </a>
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
                                            <label for="rate">Rate</label>
                                            <input type="number" class="form-control required" name="rate" id="rate"
                                                   placeholder="Rate" max="5" min="0"
                                                   value="{{ old('rate') }}">
                                            <p class="text-danger error-message" style="font-weight: bold">
                                                @error('rate')
                                                    {{ $message }}
                                                @enderror
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <div class="editor-wrapper">
                                                <textarea name="post_content" id="description" class="form-control"
                                                          style="width: 100%; height: 90px"
                                                          placeholder="Description">{{ old('description') }}</textarea>
                                            </div>
                                            <p class="text-danger error-message" style="font-weight: bold"
                                               id="description-error">
                                                @error('description')
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
                                                    <input type="file" name="images[]" style="padding: 3px 5px;overflow: hidden;" class="input-image required form-control">
                                                    <p class="text-danger error-message" style="font-weight: bold"></p>
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
                                            @if(old('room_types') && old('inventories'))
                                                @foreach(old('room_types') as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="room_types[]" value="{{ $value }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="inventories[]" value="{{ old('inventories[]')[$key] }}">
                                                        </td>
                                                        <td style="width: 120px; vertical-align: middle">
                                                            <div class="action-wrapper">
                                                                <button class="btn btn-success btn-add"><i class="dripicons-plus"></i></button>
                                                                @if($key > 0)
                                                                    <button class="btn btn-danger btn-delete"><i class="dripicons-minus"></i></button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control input-type" name="room_types[]">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control input-type" name="inventories[]">
                                                    </td>
                                                    <td style="width: 120px; vertical-align: middle">
                                                        <div class="action-wrapper">
                                                            <button class="btn btn-success btn-add"><i class="dripicons-plus"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
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
                                            @if(old('facilities'))
                                                @foreach(old('facilities') as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control input-type" name="facilities[]" value="$value">
                                                        </td>
                                                        <td style="width: 120px; vertical-align: middle">
                                                            <div class="action-wrapper">
                                                                <button class="btn btn-success btn-add"><i class="dripicons-plus"></i></button>
                                                                @if($key > 0)
                                                                    <button class="btn btn-danger btn-delete"><i class="dripicons-minus"></i></button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control input-type" name="facilities[]">
                                                    </td>
                                                    <td style="width: 120px; vertical-align: middle">
                                                        <div class="action-wrapper">
                                                            <button class="btn btn-success btn-add"><i class="dripicons-plus"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane p-3" id="map" role="tabpanel">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="text-align: center">Image</th>
                                                    <th rowspan="2" style="text-align: center">Address</th>
                                                    <th colspan="2" style="text-align: center">Location</th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center">Lat</th>
                                                    <th style="text-align: center">Long</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 260px">
                                                        <div class="preview-image" style="width: 100%;">
                                                            <div class="close">
                                                                <i class="dripicons-cross"></i>
                                                            </div>
                                                        </div>
                                                        <input type="file" class="form-control banner-image" name="map_image"  style="padding: 3px 5px; overflow: hidden">
                                                    </td>
                                                    <td><textarea type="text" class="form-control" name="map_address">{{ old('map_address') }}</textarea></td>
                                                    <td>
                                                        <input type="number" class="form-control" name="map_lat" value="{{ old('map_lat') }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="map_long" value="{{ old('map_long') }}">
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
                                <p class="text-danger error-message" style="font-weight: bold" >
                                    @error('post_title')
                                    {{ $message }}
                                    @enderror
                                </p>
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
        const slugs = JSON.parse('{!! json_encode($slugs) !!}')
        CKEDITOR.replace('description', {filebrowserImageBrowseUrl: '/file-manager/ckeditor'});
        $(document).ready(function () {
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

            $('#rate').on('change',function () {
                let val = parseInt($(this).val());
                let max = parseInt($(this).attr('max'));
                if (val < 0 ){
                    $(this).val(0);
                }
                if (val > max) {
                    $(this).val(max);
                }
            })

            // Validate File Input
            $(".banner-image").change(function () {
                let val = $(this).val();
                if (val) {
                    if (validateFileUpload(this)) {
                        readURL(this, $(this).parent().find('.preview-image'));
                        $(this).removeClass('error');
                        $(this).parents('td').find('.error-message').text('');
                        $(this).removeClass('required');
                        $(this).hide();
                    } else {
                        $(this).parents('td').find('.error-message').text('File must be JPG, GIF or PNG, less than 2MB. Please choose again');
                        $(this).parent().find('.preview-image img').remove();
                        $(this).addClass('error');
                        $(this).val('');
                    }
                } else {
                    $(this).parents('td').find('.error-message').text('This field cannot be null');
                    $(this).removeClass('error');
                    $(this).parent().find('.preview-image img').remove();
                }
            });

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

            $('body').on('click', '.btn-add', function (e) {
                e.preventDefault();
                let row = $(this).parents('tr').clone();
                row.find('img').remove();
                row.find('.input-image').val('');
                row.find('.input-image').show();
                row.find('.input-image').addClass('required');
                row.find('.action-wrapper').empty();
                row.find('.action-wrapper').append('<button class="btn btn-success btn-add"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete"><i class="dripicons-minus"></i></button>');

                // type
                row.find('.input-type').val('');

                $(this).parents('tbody').append(row);
            })
            $('body').on('click', '.btn-delete', function (e) {
                e.preventDefault();
                $(this).parents('tr').remove();
            })

            $('body').on('change', '.input-image', function () {
                let val = $(this).val();
                if (val) {
                    if (validateFileUpload(this)) {
                        readURL(this, $(this).parent().find('.preview-image'));
                        $(this).parent().find('.error-message').text('');
                        $(this).removeClass('error');
                        $(this).removeClass('required');
                        $(this).hide();
                    } else {
                        $(this).parent().find('.error-message').text('File must be JPG, GIF or PNG, less than 2MB');
                        $('.preview-image img').remove();
                        $(this).addClass('error');
                        $(this).addClass('required');
                        $(this).val('');
                        $(this).show();
                    }
                } else {
                    $(this).parent().find('.error-message').text('This field cannot be null');
                    $(this).addClass('error');
                    $(this).addClass('required');
                    $('.preview-image img').remove();
                    $(this).show();
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



    </script>
@endsection
