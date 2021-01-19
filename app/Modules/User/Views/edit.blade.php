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
    <h4 class="page-title font-size-18">Users Manage</h4>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">

                    <div class="card">
                        <div class="card-body">
                            {!! displayAlert(Session::get('message'))  !!}
                            <h4 class="card-title">Add New User</h4>
                            <form action="{{ route('user.manager.save', ['id' => $user->id]) }}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" required name="name" id="name" placeholder="Type user's name" value="{{ old('name', $user->name) }}">
                                    @if($errors->first('name')) {!! '<p class="text-danger" style="font-weight: bold" id="name-error"> '. $errors->first('name') .' </p>' !!} @endif

                                </div>

                                <div class="form-group">
                                    <label for="name">Email login</label>
                                    <input type="email" class="form-control" required name="email" id="email" placeholder="Type user's email" value="{{ old('email', $user->email) }}">
                                    @if($errors->first('email')) {!! '<p class="text-danger" style="font-weight: bold" id="email-error"> '. $errors->first('email') .' </p>' !!} @endif
                                </div>


                                <div class="form-group">
                                    <label for="parent">Role</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value="{{ \App\Core\Glosary\RoleConfigs::GUEST['VALUE'] }}">{{ \App\Core\Glosary\RoleConfigs::GUEST['DISPLAY'] }}</option>
                                        @if(isset($roles) && !empty($roles))
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ ( old('role') == $role->id || $role->id == $user->role ) ? 'selected' : false }}>{{ $role->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p style="font-style: italic; font-size: 12px">Choose the role for new user</p>
                                </div>
                                {{-- field user meta --}}

                                <div class="form-group">
                                    <label for="title">Phone</label>
                                    <input type="tel" name="phone" id="title" class="form-control" placeholder="Type user's phone" value="{{ old('phone', $phone ? $phone->meta_value : "" ) }}">
                                    <p style="font-style: italic; font-size: 12px"></p>
                                    @if($errors->first('phone')) {!! '<p class="text-danger" style="font-weight: bold" id="email-phone"> '. $errors->first('phone') .' </p>' !!} @endif
                                </div>

                                {{-- end field user meta --}}

{{--                                <div class="form-group">--}}
{{--                                    <label for="name">Change password</label>--}}
{{--                                    <input type="password" class="form-control" name="password" id="password" placeholder="Type new  password">--}}
{{--                                    <p class="text-danger" style="font-weight: bold" id="name-error"></p>--}}
{{--                                    @if($errors->first('password')) {!! '<p class="text-danger" style="font-weight: bold"> '. $errors->first('password') .' </p>' !!} @endif--}}
{{--                                </div>--}}

{{--                                <div class="form-group">--}}
{{--                                    <label for="name">Confirm new password</label>--}}
{{--                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Type confirm new password">--}}
{{--                                    <p class="text-danger" style="font-weight: bold" id="name-error"></p>--}}
{{--                                    @if($errors->first('password_confirmation')) {!! '<p class="text-danger" style="font-weight: bold"> '. $errors->first('password_confirmation') .' </p>' !!} @endif--}}
{{--                                </div>--}}

                                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
