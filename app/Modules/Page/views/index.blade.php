@extends('backend.default')
@section('title')
    All Pages
@endsection
@section('style')
    <style>
        .control-wrapper {
            margin-bottom: 1rem;
            text-align: right;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">All Page</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        @include('backend.elements.languages')
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="control-wrapper">
                        <a href="{{ route('page.add') }}" class="btn btn-success" style="margin-right: 1rem">Add Page</a>
                        <button class="btn btn-warning btn-delete-many">Delete Selected</button>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center"><input type="checkbox" name="" id="checkAll"></th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($pages))
                                @foreach($pages as $value)
                                    <tr>
                                        <td style="text-align: center"><input type="checkbox" class="cate-check" data-id="{{ $value->postId }}" name="" id=""></td>
                                        <td><a href="{{ route('detail',$value->slug) }}" target="_blank">{{ $value->postTitle }}</a></td>
                                        <td>{{ $value->postAuthor }}</td>
                                        <td>{{ \App\Core\Glosary\PostStatus::display($value->postStatus) }}</td>
                                        <td>{{ $value->createdAt }}</td>
                                        <td>{{ $value->updatedAt }}</td>
                                        <td style="width: 150px">
                                            <div class="btn-wrapper" style="display: flex; align-items: center;justify-content: center">
                                                <a href="{{ route('page.edit',$value->postId) }}" target="_blank" class="btn btn-primary btn-edit" style="margin-right: 10px">Edit</a>
                                                <button class="btn btn-danger btn-delete" data-id="{{ $value->postId }}">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
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
                    title: 'Do you want to delete these pages ?',
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
                            url : '{{ route('page.delete.many') }}',
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
                                        window.location.href= '{{ route('post.index') }}';
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
                            url : '{{ route('post.delete') }}',
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
                                        window.location.href= '{{ route('page.index') }}';
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
    </script>
@endsection
