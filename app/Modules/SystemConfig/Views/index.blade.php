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
    </style>
@endsection
@section('heading')
    <h4 class="page-title font-size-18">General Settings</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            {!! displayAlert(Session::get('message'))  !!}
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('system.index') }}" method="post">
                        @csrf
                        <div class="form-group media-load-image">
                            <label for="logo">Logo:</label>
                            @if(isset($result->logo))
                                {!! renderMediaManage('logo',$result->logo) !!}
                            @else
                                {!! renderMediaManage('logo') !!}
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="phone">Site Title:</label>
                            <input type="text" class="form-control" name="site_title" id="site_title" value="{{ isset($result->site_title) ? $result->site_title : "" }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Tagline:</label>
                            <input type="text" class="form-control" name="site_tagline" id="site_tagline" value="{{ isset($result->site_tagline) ? $result->site_tagline : "" }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Administration Email Address	:</label>
                            <input type="text" class="form-control" name="site_admin_mail" id="site_admin_mail" value="{{ isset($result->site_admin_mail) ? $result->site_admin_mail : "" }}">
                        </div>


                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ isset($result->phone) ? $result->phone : "" }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" name="email " id="email" value="{{ isset($result->email) ? $result->email : "" }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{ isset($result->address) ? $result->address : "" }}">
                        </div>
                        <div class="form-group">
                            <label>Social links:</label>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>Facebook:</th>
                                    <td>
                                        <input type="text" class="form-control" name="social_links[]" value="{{ isset($result->social_link[0]) ? $result->social_link[0] : "" }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Twitter:</th>
                                    <td>
                                        <input type="text" class="form-control" name="social_links[]" value="{{ isset($result->social_link[1]) ? $result->social_link[1] : "" }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Instagram:</th>
                                    <td>
                                        <input type="text" class="form-control" name="social_links[]" value="{{ isset($result->social_link[2]) ? $result->social_link[2] : "" }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Youtube:</th>
                                    <td>
                                        <input type="text" class="form-control" name="social_links[]" value="{{ isset($result->social_link[3]) ? $result->social_link[3] : "" }}">
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
