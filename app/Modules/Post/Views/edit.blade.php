@extends('backend.default')
@section('title')
    Edit Hotel
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
        .preview-image img {
            width: 100%;
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
        .hidden {
            display: none;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Edit Hotel</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="alert alert-danger alert-common" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Some fields need to required. Please check it again !
            </div>
            <form action="{{ route('post.edit',$post['id']) }}" id="add-form" method="post" role="form" enctype="multipart/form-data">
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
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#map" role="tab"> Map settings </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    @csrf
                                    <input type="hidden" id="postId" value="{{ $post['id'] }}">
                                    <div class="tab-pane active p-3" id="common" role="tabpanel">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control required" name="post_title" id="title"
                                                   placeholder="Title"
                                                   value="{{ old('post_title') ? old('post_title') : $post['post_title'] }}">
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
                                                   value="{{ old('post_name') ? old('post_name') : $post['post_name'] }}">
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
                                                   value="{{ old('rate') ? old('rate') : $postMetaMap[\App\Core\Glosary\MetaKey::RATE['VALUE']] }}">
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
                                                          placeholder="Description">{{ $post['post_content'] }}</textarea>
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
                                                $banner = $postMetaMap[\App\Core\Glosary\MetaKey::BANNER['VALUE']];
                                            @endphp
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <th style="vertical-align: middle; width: 100px">Desktop</th>
                                                    <td>
                                                        <div class="preview-image">
                                                            <div class="close @if($banner[0] == '') {{ 'deleted' }} @endif">
                                                                <i class="dripicons-cross"></i>
                                                            </div>
                                                            @if($banner[0] != '')
                                                                <img src="{{ asset($banner[0]) }}" alt="">
                                                            @endif
                                                        </div>
                                                        <input type="file" style="padding: 3px 5px; overflow: hidden;"
                                                               class="form-control banner-image @if($banner[0] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"
                                                               name="files[]">
                                                        <input type="hidden" class="banner-link" name="banner[]" data-type="{{ \App\Core\Glosary\MetaKey::BANNER['VALUE'] }}" value="{{ $banner[0] }}">
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
                                                        <div class="preview-image">
                                                            <div class="close @if($banner[1] == '') {{ 'deleted' }} @endif">
                                                                <i class="dripicons-cross"></i>
                                                            </div>
                                                            @if($banner[1] != '')
                                                                <img src="{{ asset($banner[1]) }}" alt="">
                                                            @endif
                                                        </div>
                                                        <input type="file" style="padding: 3px 5px; overflow: hidden;"
                                                               class="form-control banner-image @if($banner[1] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"
                                                               name="files[]">
                                                        <input type="hidden" class="banner-link" name="banner[]" data-type="{{ \App\Core\Glosary\MetaKey::BANNER['VALUE'] }}" value="{{ $banner[1] }}">
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
                                                        <div class="preview-image">
                                                            <div class="close @if($banner[2] == '') {{ 'deleted' }} @endif">
                                                                <i class="dripicons-cross"></i>
                                                            </div>
                                                            @if($banner[2] != '')
                                                                <img src="{{ asset($banner[2]) }}" alt="">
                                                            @endif
                                                        </div>
                                                        <input type="file" style="padding: 3px 5px; overflow: hidden;"
                                                               class="form-control banner-image @if($banner[2] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"
                                                               name="files[]">
                                                        <input type="hidden" class="banner-link" name="banner[]" data-type="{{ \App\Core\Glosary\MetaKey::BANNER['VALUE'] }}" value="{{ $banner[2] }}">
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
                                        <table class="table-bordered table">
                                            <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $slides = $postMetaMap[\App\Core\Glosary\MetaKey::SLIDE['VALUE']];
                                            @endphp
                                            @if(isset($slides) && !empty($slides))
                                                @foreach($slides as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <div class="preview-image">
                                                                <div class="close">
                                                                    <i class="dripicons-cross"></i>
                                                                </div>
                                                                @if($value != '')
                                                                    <img src="{{ asset($value) }}" alt="">
                                                                @endif
                                                            </div>
                                                            <input type="file" style="padding: 3px 5px; overflow: hidden;" class="form-control input-image @if($value != '') {{ 'hidden' }} @else {{'required'}} @endif" name="images[]">
                                                            <input type="hidden" class="banner-link" data-type="{{ \App\Core\Glosary\MetaKey::SLIDE['VALUE'] }}" value="{{ $value }}" name="imageMap[]">
                                                            <p class="text-danger error-message" style="font-weight: bold"></p>
                                                        </td>
                                                        <td style="width: 120px; vertical-align: middle">
                                                            <div class="action-wrapper">
                                                                <button class="btn btn-success btn-add"><i class="dripicons-plus"></i>
                                                                </button>
                                                                @if($key > 0)
                                                                    <button class="btn btn-danger btn-delete"><i class="dripicons-minus"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <div class="preview-image">
                                                            <div class="close">
                                                                <i class="dripicons-cross"></i>
                                                            </div>

                                                        </div>
                                                        <input type="file" style="padding: 3px 5px; overflow: hidden;" class="form-control input-image " name="images[]">
                                                        <p class="text-danger error-message" style="font-weight: bold"></p>
                                                    </td>
                                                    <td style="width: 120px; vertical-align: middle">
                                                        <div class="action-wrapper">
                                                            <button class="btn btn-success btn-add"><i class="dripicons-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
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
                                            @php
                                                $types = $postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['VALUE']];
                                            @endphp
                                            @if(isset($types) && !empty($types))
                                                @foreach($types as $key => $value)
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control input-type" name="room_types[]" value="{{ $value->type }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control input-type" name="inventories[]" value="{{ $value->inven }}">
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
                                                @php
                                                    $facilities = $postMetaMap[\App\Core\Glosary\MetaKey::FACILITY['VALUE']];
                                                @endphp
                                                @if(isset($facilities) && !empty($facilities))
                                                    @foreach($facilities as $key => $value)
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control input-type" name="facilities[]" value="{{ $value }}">
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
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane p-3" id="map" role="tabpanel">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Image</th>
                                                    <th rowspan="2" style="text-align: center; vertical-align: middle">Address</th>
                                                    <th colspan="2" style="text-align: center; vertical-align: middle">Location</th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center">Lat</th>
                                                    <th style="text-align: center">Long</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $map = $postMetaMap[\App\Core\Glosary\MetaKey::LOCATION['VALUE']];
                                                @endphp
                                                <tr>
                                                    <td style="width: 260px">
                                                        <div class="preview-image" style="width: 100%;">
                                                            <div class="close">
                                                                <i class="dripicons-cross"></i>
                                                            </div>
                                                            @if($map->image != '' && !empty($map->image))
                                                                <img src="{{ asset($map->image) }}"  alt="">
                                                            @endif
                                                        </div>
                                                        <input type="file" class="form-control banner-image @if($map->image != '' && !empty($map->image)) {{ 'hidden' }} @endif" name="map_image"  style="padding: 3px 5px; overflow: hidden">
                                                    </td>
                                                    <td><textarea type="text" class="form-control" name="map_address">{{ old('map_address') ? old('map_address') : $map->address}}</textarea></td>
                                                    <td>
                                                        <input type="number" class="form-control" name="map_lat" value="{{ old('map_lat') ? old('map_lat') : $map->location->lat }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="map_long" value="{{ old('map_long') ? old('map_long') : $map->location->long}}">
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
                                    <p><i class="dripicons-flag"></i> Status : {{ \App\Core\Glosary\PostStatus::display($post['post_status']) }}</p>
                                    <a href="#" target="_blank"><i class="dripicons-web"></i> Make translation</a>
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
                                            <option value="{{ $value['id'] }}" {{ $value['id'] == $term_id['term_taxonomy_id'] ? 'selected':'' }}>{{ $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger error-message" style="font-weight: bold">
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
                    $(this).val(changeToSlug($('#name').val()));
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
                $(this).parents('td').find('img').remove();
                $(this).parents('td').parent().find('input[type=file]').val('');
                $(this).parents('td').find('input[type=file]').show();
                $(this).parents('td').find('.input-image').addClass('required');
                $(this).parents('td').find('.banner-link').val('');
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

            $('body').on('click', '.btn-add', function (e) {
                e.preventDefault();
                let row = $(this).parents('tr').clone();

                $(this).parents('tbody').append(row);
                row.find('img').remove();
                row.find('.input-image').val('');
                row.find('.input-image').show();
                row.find('.input-image').addClass('required');
                row.find('.banner-link').val('');
                row.find('.action-wrapper').empty();
                row.find('.action-wrapper').append('<button class="btn btn-success btn-add"><i class="dripicons-plus"></i></button><button class="btn btn-danger btn-delete"><i class="dripicons-minus"></i></button>');

                // type
                row.find('.input-type').val('');

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
                let reader = new FileReader();
                element.find('img').remove();
                let name = input.files[0].name;
                reader.onload = function (e) {
                    let html = '<img style="width: 100%" src="' + e.target.result + '"  title="name" alt="your image" />';
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
                    $(this).parent().parent().find('.error-message').text('This field cannot be null');
                    valid = false;
                } else {
                    $(this).removeClass('error');
                    $(this).parent().parent().find('.error-message').text('');
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

