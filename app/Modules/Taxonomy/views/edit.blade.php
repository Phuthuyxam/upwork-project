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
                            <label for="file">Banner</label>
                            <div class="preview-image">
                                <div class="close @if(!isset($result['file']) || empty($result['file'])) {{ 'deleted' }} @endif" data-id="{{ $result['id'] }}">
                                    <i class="dripicons-cross"></i>
                                </div>
                                @if(isset($result['file']) && !empty($result['file']))
                                    <img src="{{ asset('storage/categories/'.$result['file']) }}" alt="">
                                @endif
                            </div>
                            <input type="file" style="padding: 3px 5px; overflow: hidden;" class="form-control  @if(isset($result['file']) && !empty($result['file'])) {{ 'd-none ' }} @else {{ 'required' }} @endif" name="file" id="file" value="{{ old('file') }}">
                            <input type="hidden" name="fileName" value="{{ $result['file'] }}">
                            <p class="text-danger error-message" style="font-weight: bold" id="file-error">
                                @error('file')
                                {{ $message }}
                                @enderror
                            </p>
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
                } else {
                    $(this).addClass('error');
                    $('#name-error').text("This field cannot be null");
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
            $("#file").change(function () {
                let val = $(this).val();
                if (val) {
                    if (validateFileUpload(val)) {
                        readURL(this);
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
                                    termId: termId
                                },
                                success: function (response) {
                                    if (response == 200) {
                                        Swal.fire({
                                            type: 'success',
                                            title: 'Deleted !',
                                            text: 'Category has been deleted.',
                                        }).then((result) => {
                                            self.parent().find('img').remove();
                                            $('#file').val('');
                                            $('#file').show();
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
                console.log(checkRequired('add-form'))
                if (checkRequired('add-form')) {
                    $('#add-form').submit();
                }
            })
        })
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let html = '<img id="image" style="width: 100%" src="'+e.target.result+'" alt="your image" />';
                    $('.preview-image').append(html);
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
