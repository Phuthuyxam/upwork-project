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
        .list-option {
            margin: 20px 0px;
            list-style: none;
            padding-left: 0px;
        }
        .list-option li {

            border: solid thin #0F355E;
        }
        .list-option .active {
            background: #0F355E;
            color: #ffffff;
        }
        .list-option a {
            padding: 10px;
            display: block;
            color: #0a0a0a;
        }
        .list-option .active a {
            color: #ffffff;
        }
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">Options Manage</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">


            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Option</h4>
                            @if(isset($allOption) && !empty($allOption))
                            <ul class="list-option">
                                @foreach($allOption as $option)
                                    <li class="{{ ($option['VALUE'] == $key) ? 'active' : false }}">
                                        <a href="{{ route('option.index', ['key' => $option['VALUE']]) }}"> {{ $option['DISPLAY'] }} </a>
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            {!! displayAlert(Session::get('message'))  !!}
                            <form action="{{ route('option.save', ['key' => $key]) }}" method="POST">
                                @csrf
                                @include('Setting::elements.'.$key)

                                <div class="submit-section">
                                    <div class="form-group mb-0">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
{{--        function deleteUser(id) {--}}
{{--            if(confirm("are you sure delete user?"))--}}
{{--                $('#deleteuser'+id).submit();--}}
{{--        }--}}

    $('body').on('click','.btn-add-type',function (e){
        e.preventDefault();
        let row = $(this).parents('tr').clone();
        row.find('.action-wrapper').empty();
        row.find('.action-wrapper').append('<button type="button" class="btn btn-success btn-add-type" style="margin-right: 30px"><i class="dripicons-plus"></i></button><button type="button" class="btn btn-danger btn-delete-type"><i class="dripicons-minus"></i></button>');
        row.find('.option-menu-title').val('');
        row.find('.option-menu-url').val('');
        $(this).parents('tbody').append(row);
    })
    $('body').on('click','.btn-delete-type',function (e){
        e.preventDefault();
        $(this).parents('tr').remove();
    })
    </script>

@endsection
