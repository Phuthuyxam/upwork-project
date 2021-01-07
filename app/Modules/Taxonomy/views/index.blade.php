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
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Category</h4>
                            <form action="{{ route('taxonomy.add') }}" method="post" role="form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                    <p style="font-style: italic; font-size: 12px">The name is how it appears on your
                                        website</p>
                                    <p class="text-danger" style="font-weight: bold" id="name-error"></p>
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug">
                                    <p style="font-style: italic; font-size: 12px">The "slug" is the URL-friendly of the
                                        name. It is usually all lower case and contains only letters, numbers, and
                                        hyphens</p>
                                </div>
                                <div class="form-group">
                                    <label for="parent">Parent</label>
                                    <select name="parent" class="form-control" id="parent">
                                        <option value="-1">None</option>
                                    </select>
                                    <p style="font-style: italic; font-size: 12px">Categories can have a hierarchy. You
                                        might have and Jazz category, and under that have children categories for Debop
                                        and Big Band. Totally optional</p>
                                </div>
                                <div class="form-group">
                                    <label for="file">Banner</label>
                                    <div class="preview-image">
                                        <div class="close">
                                            <i class="dripicons-cross"></i>
                                        </div>
                                    </div>
                                    <input type="file" style="padding: 3px 5px; overflow: hidden" class="form-control" name="file" id="file">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input name="title" id="title" class="form-control" placeholder="Title">
                                    <p style="font-style: italic; font-size: 12px"></p>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control"
                                              style="width: 100%; height: 90px" placeholder="Description"></textarea>
                                    <p style="font-style: italic; font-size: 12px">Description for your category.
                                        Totally optional</p>
                                </div>
                                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-wrapper">
                                <table class="table table-striped table-hover" id="cate-table">
                                    <thead>
                                    <tr>
                                        <th style="color:#1967a9;">Name</th>
                                        <th style="color:#1967a9;">Description</th>
                                        <th style="color:#1967a9;">Slug</th>
                                        <th style="color:#1967a9;">Count</th>
                                        <th style="color:#1967a9; text-align: center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($categories) && !empty($categories))
                                            @foreach($categories as $value)
                                                <tr>
                                                    <td><a href="#">{{ $value->name }}</a></td>
                                                    <td>{{ $value->description }}</td>
                                                    <td>{{ $value->slug }}</td>
                                                    <td></td>
                                                    <td>
                                                        <div class="btn-wrapper" style="display: flex; align-items: center;justify-content: center">
                                                            <button class="btn btn-primary btn-edit" style="margin-right: 10px">Edit</button>
                                                            <button class="btn btn-danger btn-delete" data-id="{{ $value->id }}">Delete</button>
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
        $(document).ready(function (){
            $('#name').on('change',function (){
                let val = $(this).val();
                $('#slug').val(changeToSlug(val));
                if (val.trim() !== '') {
                    $(this).removeClass('error');
                    $('#name-error').text("");
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
                    $.ajax({
                        type : 'POST',
                        url : '{{ route('taxonomy.delete') }}',
                        data : {
                            _token : '{{ csrf_token() }}',
                            id : id
                        },
                        success: function (response){
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
                    if (result.value) {

                    }
                })
            })
            $("#file").change(function() {
                if ($(this).val()) {
                    readURL(this);
                }else {
                    $('.preview-image img').remove();
                }
            });
            $('.preview-image .close').click(function (){
                $(this).parent().find('img').remove();
                $('#file').val('');
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

    </script>
@endsection
