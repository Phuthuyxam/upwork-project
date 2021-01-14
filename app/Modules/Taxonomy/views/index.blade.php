@extends('backend.default')
@section('title')
    All Taxonomy
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
            background: #ccc;
            margin-bottom: 1rem;
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
    <h4 class="page-title font-size-18">Categories</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('backend.elements.languages')
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Category</h4>
                            <form action="{{ route('taxonomy.add') }}" id="add-form" method="post" role="form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control required" name="name" id="name" placeholder="Name" value="{{ old('name') }}">
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
                                    <input type="text" class="form-control required" name="slug" id="slug" placeholder="Slug" value="{{ old('slug') }}">
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
                                    <label>Logo</label>
                                    {!!  renderMediaManage('logo') !!}
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control required"
                                              style="width: 100%; height: 90px" placeholder="Description">{{ old('description') }}</textarea>
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
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-warning btn-delete-many" style="float: right; margin-bottom: 1rem" disabled>Delete Selected</button>
                            <div class="table-wrapper">
                                <table class="table table-striped table-hover" id="cate-table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" id="checkAll"></th>
                                            <th style="color:#1967a9;">Name</th>
{{--                                            <th style="color:#1967a9;">Translation</th>--}}
                                            <th style="color:#1967a9;">Slug</th>
{{--                                            <th style="color:#1967a9;">Count</th>--}}
                                            <th style="color:#1967a9; text-align: center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($categories) && !empty($categories))
                                            @foreach($categories as $value)
                                                <tr>
                                                    <td><input type="checkbox" class="cate-check" data-id="{{ $value->term_id }}" name="" id=""></td>
                                                    <td><a href="#">{{ $value->name }}</a></td>
{{--                                                    <td><a href="#" target="_blank"><i class="dripicons-web"></i> Make translation</a></td>--}}
                                                    <td>{{ $value->slug }}</td>
{{--                                                    <td></td>--}}
                                                    <td>
                                                        <div class="btn-wrapper" style="display: flex; align-items: center;justify-content: center">
                                                            <a href="{{ route('taxonomy.edit',$value->term_id) }}" class="btn btn-primary btn-edit" style="margin-right: 10px">Edit</a>
                                                            <button class="btn btn-danger btn-delete" data-id="{{ $value->term_id }}">Delete</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper">
                                    {{ $categories->links('backend.elements.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const slugs = JSON.parse('{!! json_encode($slugs) !!}');
        $(document).ready(function (){
            // Validate Name
            $('#name').on('change',function (){
                let val = $(this).val();
                $('#slug').val(changeToSlug(val));
                if (val.trim() !== '') {
                    $(this).removeClass('error');
                    $('#name-error').text("");
                    $('#slug').removeClass('error required');
                    $('#slug-error').text('');
                }else {
                    $(this).addClass('error');
                    $('#name-error').text("This field cannot be null");
                    $('#slug').addClass('required');
                }
            })

            $('#slug').on('change',function () {
                let val = $(this).val();
                if (val.trim() === '') {
                    $(this).val(changeToSlug($('#name').val()));
                }else{
                    if (slugs.indexOf(val) >= 0) {
                        $('#slug-error').text('Slug already exist');
                        $(this).addClass('error');
                    }else{
                        $('#slug-error').text('');
                        $(this).removeClass('error');
                    }
                }
            })
            // Validate File Input
            $('#description').on('change',function () {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('error');
                    $('#description-error').text('')
                }
            })

            $('.btn-submit').click(function (e){
                e.preventDefault();
                if (checkRequired('add-form')) {
                    $('#add-form').submit();
                }else{
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops... !',
                        text: 'Some field need to required. Please check it again',
                    })
                }
            })

            $('.btn-delete').click(function (){
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $('#loading').show();
                        $.ajax({
                            type : 'POST',
                            url : '{{ route('taxonomy.delete') }}',
                            data : {
                                _token : '{{ csrf_token() }}',
                                id : id
                            },
                            success: function (response){
                                $('#loading').hide();
                                if (response == 200) {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Deleted !',
                                        text: 'Category has been deleted.',
                                    }).then((result) => {
                                        window.location.href= '{{ route('taxonomy.index') }}';
                                    })
                                }else{
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops... !',
                                        text: 'Something went wrong.',
                                    })
                                }
                            },
                            error: function (e) {
                                console.log(e);
                            }
                        })
                    }
                })
            })
        })

        let checkArr = [];
        $('.cate-check').each(function (){
            checkArr.push(0);
        })
        $('#checkAll').on('change',function () {
            if ($(this).prop('checked')){
                $(this).parents('table').find('tbody tr').each(function (i){
                    $(this).find('.cate-check').prop('checked',true);
                    checkArr[i] = 1;
                })
                $('.btn-delete-many').prop('disabled',false);
            }else{
                $(this).parents('table').find('tbody tr').each(function (i){
                    $(this).find('.cate-check').prop('checked',false);
                    checkArr[i] = 0;
                });
                $('.btn-delete-many').prop('disabled',true);
            }
        })

        $('.cate-check').on('change',function (){
            $(this).parents('table').find('tbody tr .cate-check').each(function (i){
                let self = this;
                if ($('.cate-check').index(self) == i ) {
                    if ($(this).prop('checked')) {
                        checkArr[i] = 1;
                    }else{
                        checkArr[i] = 0;
                    }
                }
            })
            if (checkArr.indexOf(1) < 0 || checkArr.indexOf(0) >= 0) {
                $('#checkAll').prop('checked',false);
            }
            if (checkArr.indexOf(0) < 0) {
                $('#checkAll').prop('checked',true);
            }
            if (checkArr.indexOf(1) < 0) {
                $('.btn-delete-many').prop('disabled',true);
            }else{
                $('.btn-delete-many').prop('disabled',false);
            }
        })

        $('.btn-delete-many').click(function (){
            let ids = "";
            $('.cate-check').each(function (){
                if ($(this).prop('checked')) {
                    ids += $(this).data('id')+',';
                }
            })
            ids = ids.substr(0,ids.length-1);
            Swal.fire({
                title: 'Do you want to delete these categories?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $('#loading').show();
                    $.ajax({
                        type : 'POST',
                        url : '{{ route('taxonomy.delete.many') }}',
                        data : {
                            _token : '{{ csrf_token() }}',
                            ids : ids
                        },
                        success: function (response){
                            $('#loading').hide();
                            if (response == 200) {
                                Swal.fire({
                                    type: 'success',
                                    title: 'Deleted !',
                                    text: 'Category has been deleted.',
                                }).then(() => {
                                    window.location.href= '{{ route('taxonomy.index') }}';
                                })
                            }else{
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops... !',
                                    text: 'Something went wrong.',
                                })
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    })
                }
            })
        })

        function checkRequired(formId) {
            let valid = true;
            $('#'+formId).find('.required').each(function (){
                if ($(this).val().trim() === '') {
                    $(this).addClass('error');
                    $(this).parent().find('.error-message').text('This field cannot be null');
                    valid = false;
                }else{
                    $(this).removeClass('error');
                    $(this).parent().find('.error-message').text('');
                }
            })

            return valid;
        }
    </script>
@endsection
