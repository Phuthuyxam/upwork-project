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
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="parent">Parent</label>--}}
                        {{--                                    <select name="parent" class="form-control" id="parent">--}}
                        {{--                                        <option value="-1">None</option>--}}
                        {{--                                    </select>--}}
                        {{--                                    <p style="font-style: italic; font-size: 12px">Categories can have a hierarchy. You--}}
                        {{--                                        might have and Jazz category, and under that have children categories for Debop--}}
                        {{--                                        and Big Band. Totally optional</p>--}}
                        {{--                                </div>--}}
                        <div class="form-group">
                            <label for="layout">Layout</label>
                            <select name="layout" class="form-control" id="layout">
                                @foreach(\App\Core\Glosary\TaxonomyType::getAll() as $value)
                                    <option value="{{ $value['VALUE'] }}" @if($value['VALUE'] == $taxonomy['taxonomy']) selected @endif> {{ $value['NAME'] }}</option>
                                @endforeach
                            </select>
                            <p style="font-style: italic; font-size: 12px">Choose layout to appear in Front. Default is Hotel,
                                Service will not have detail page</p>
                        </div>
                        <div class="form-group">
                            <label for="file">Banner</label>
                            <table class="table table-bordered">
                                @php
                                    $banner = json_decode($result['file']);
                                @endphp
                                <tr>
                                    <th style="vertical-align: middle">Desktop</th>
                                    <td>
                                        <div class="preview-image">
                                            <div class="close @if(!isset($banner[0]) || empty($banner[0])) {{ 'deleted' }} @endif" data-id="{{ $result['id'] }}">
                                                <i class="dripicons-cross"></i>
                                            </div>
                                            @if(isset($banner[0]) && !empty($banner[0]))
                                                <img src="{{ asset($banner[0]) }}" alt="">
                                            @endif
                                        </div>
                                        <input type="file" style="padding: 3px 5px; overflow: hidden;"
                                               class="form-control banner-image @if($banner[0] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"
                                               name="files[]">
                                        <input type="hidden" class="banner-link" name="banner[]" value="{{ $banner[0] }}">
                                        <p class="text-danger error-message" style="font-weight: bold">
                                            @error('file')
                                            {{ $message }}
                                            @enderror
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle">Tablet</th>
                                    <td>
                                        <div class="preview-image">
                                            <div class="close @if(!isset($banner[1]) || empty($banner[1])) {{ 'deleted' }} @endif" data-id="{{ $result['id'] }}">
                                                <i class="dripicons-cross"></i>
                                            </div>
                                            @if(isset($banner[1]) && !empty($banner[1]))
                                                <img src="{{ asset($banner[1]) }}" alt="">
                                            @endif
                                        </div>
                                        <input type="file" style="padding: 3px 5px; overflow: hidden;"
                                               class="form-control banner-image @if($banner[1] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"
                                               name="files[]">
                                        <input type="hidden" class="banner-link" name="banner[]"  value="{{ $banner[1] }}">
                                        <p class="text-danger error-message" style="font-weight: bold">
                                            @error('file')
                                            {{ $message }}
                                            @enderror
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle">Mobile</th>
                                    <td>
                                        <div class="preview-image">
                                            <div class="close @if(!isset($banner[2]) || empty($banner[2])) {{ 'deleted' }} @endif" data-id="{{ $result['id'] }}">
                                                <i class="dripicons-cross"></i>
                                            </div>
                                            @if(isset($banner[2]) && !empty($banner[2]))
                                                <img src="{{ asset($banner[2]) }}" alt="">
                                            @endif
                                        </div>
                                        <input type="file" style="padding: 3px 5px; overflow: hidden;"
                                               class="form-control banner-image @if($banner[2] != '') {{ 'hidden' }} @else {{ 'required' }} @endif"
                                               name="files[]">
                                        <input type="hidden" class="banner-link" name="banner[]"  value="{{ $banner[2] }}">
                                        <p class="text-danger error-message" style="font-weight: bold">
                                            @error('file')
                                            {{ $message }}
                                            @enderror
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input name="title" id="title" class="form-control required" placeholder="Title" value="{{ old('title') ? old('title') : $result['title'] }}">
                            <p style="font-style: italic; font-size: 12px"></p>
                            <p class="text-danger error-message" style="font-weight: bold"  id="title-error">
                                @error('title')
                                {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control required"
                                      style="width: 100%; height: 90px" placeholder="Description" >{{ old('description') ? old('description') : $result['description'] }}</textarea>
                            <p style="font-style: italic; font-size: 12px">Description for your category.
                                Totally optional</p>
                            <p class="text-danger error-message" style="font-weight: bold" id="description-error" >
                                @error('description')
                                {{ $message }}
                                @enderror
                            </p>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
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
            // Validate File Input
            $(".banner-image").change(function () {
                let val = $(this).val();
                if (val) {
                    if (validateFileUpload(val)) {
                        readURL(this,$(this).parents('td').find('.preview-image'));
                        $(this).removeClass('error');
                        $(this).parents('td').find('.error-message').text('');
                        $(this).removeClass('required');
                        $(this).hide();
                    } else {
                        $(this).parents('td').find('.error-message').text('File extension is not allow');
                        $('.preview-image img').remove();
                        $(this).addClass('error');
                    }
                } else {
                    $(this).parents('td').find('.error-message').text('This field cannot be null');
                    $(this).removeClass('error');
                    $('.preview-image img').remove();
                }
            });

            $('#title').on('change', function () {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('error');
                    $('#title-error').text('')
                }
            })
            $('#description').on('change', function () {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('error');
                    $('#description-error').text('')
                }
            })
            $('.preview-image .close').click(function () {
                let self = $(this);
                let termId = $(this).data('id');
                let data = $(this).parents('td').find('.banner-link').val();
                if (!self.hasClass('deleted')) {
                    Swal.fire({
                        title: 'Are you sure you want to delete ?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('taxonomy.delete.image') }}',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    termId: termId,
                                    data : data
                                },
                                success: function (response) {
                                    if (response == 200) {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Deleted !',
                                            text: 'Category has been deleted.',
                                        }).then((result) => {
                                            self.parent().find('img').remove();
                                            self.parent().parent().find('input[type=file]').val('');
                                            self.parent().parent().find('input[type=file]').show();
                                            self.addClass('deleted');
                                        })
                                    } else {
                                        Swal.fire({
                                            type: 'error',
                                            title: 'Oops... !',
                                            text: 'Something went wrong. Try again later',
                                        })
                                    }
                                },
                                error: function (e) {
                                    console.log(e);
                                }
                            })
                        }
                    })
                }else{
                    self.parent().find('img').remove();
                    $('#file').val('');
                    $('#file').show();
                }
            })

            $('.btn-submit').click(function (e) {
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#add-form').submit();
                }
            })
        })
        function readURL(input,element) {
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
    </script>
@endsection
