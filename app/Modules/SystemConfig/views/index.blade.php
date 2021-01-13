@extends('backend.default')
@section('title')
    General Settings
@endsection
@section('style')
    <style>
        .preview-image {
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
            background: #ccc;
            width: 40% !important;
        }
        .preview-image .close {
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
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">General Settings</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('system.index') }}" method="post">
                        @csrf
                        <div class="form-group media-load-image">
                            <label for="logo">Logo:</label>
                            {!! renderMediaManage('logo',$result['logo']) !!}
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $result['phone'] }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="phone" id="email">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" name="phone" id="address">
                        </div>
                        <div class="form-group">
                            <label>Social links:</label>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Facebook:</th>
                                        <td>
                                            <input type="text" class="form-control" name="social_links[]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Twitter:</th>
                                        <td>
                                            <input type="text" class="form-control" name="social_links[]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Instagram:</th>
                                        <td>
                                            <input type="text" class="form-control" name="social_links[]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Youtube:</th>
                                        <td>
                                            <input type="text" class="form-control" name="social_links[]">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="btn-submit-wwrapper">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
