@extends('backend.default')
@section('title')
    User Manager
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
        {!! displayAlert(Session::get('message'))  !!}

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New User</h4>
                        <form action="{{ route('user.manager.add') }}" method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" required name="name" id="name" placeholder="Type user's name" value="{{ old('name') }}">
                                @if($errors->first('name')) {!! '<p class="text-danger" style="font-weight: bold" id="name-error"> '. $errors->first('name') .' </p>' !!} @endif

                            </div>

                            <div class="form-group">
                                <label for="name">Email login</label>
                                <input type="email" class="form-control" required name="email" id="email" placeholder="Type user's email" value="{{ old('email') }}">
                                @if($errors->first('email')) {!! '<p class="text-danger" style="font-weight: bold" id="email-error"> '. $errors->first('email') .' </p>' !!} @endif
                            </div>


                            <div class="form-group">
                                <label for="parent">Role</label>
                                <select class="form-control" name="role" id="role">
                                    <option value="{{ \App\Core\Glosary\RoleConfigs::GUEST['VALUE'] }}">{{ \App\Core\Glosary\RoleConfigs::GUEST['DISPLAY'] }}</option>
                                    @if(isset($roles) && !empty($roles))
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ ( old('role') == $role->id ) ? 'selected' : false }}>{{ $role->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p style="font-style: italic; font-size: 12px">Choose the role for new user</p>
                            </div>
                            {{-- field user meta --}}

                            <div class="form-group">
                                <label for="title">Phone</label>
                                <input type="tel" name="phone" id="title" class="form-control" placeholder="Type user's phone" value="{{ old('phone') }}">
                                <p style="font-style: italic; font-size: 12px"></p>
                                @if($errors->first('phone')) {!! '<p class="text-danger" style="font-weight: bold" id="email-phone"> '. $errors->first('phone') .' </p>' !!} @endif
                            </div>

                            {{-- end field user meta --}}
{{--                            <div class="form-group">--}}
{{--                                <label for="name">Password</label>--}}
{{--                                <input type="password" class="form-control" required name="password" id="password" placeholder="Type user's password">--}}
{{--                                <p class="text-danger" style="font-weight: bold" id="name-error"></p>--}}
{{--                                @if($errors->first('password')) {!! '<p class="text-danger" style="font-weight: bold"> '. $errors->first('password') .' </p>' !!} @endif--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <label for="name">Confirm Password</label>--}}
{{--                                <input type="password" class="form-control" required name="password_confirmation" id="password_confirmation" placeholder="Type confirm password">--}}
{{--                                <p class="text-danger" style="font-weight: bold" id="name-error"></p>--}}
{{--                                @if($errors->first('password_confirmation')) {!! '<p class="text-danger" style="font-weight: bold"> '. $errors->first('password_confirmation') .' </p>' !!} @endif--}}
{{--                            </div>--}}

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
                                    <th style="color:#1967a9;">Email</th>
                                    <th style="color:#1967a9;">Role</th>
                                    <th style="color:#1967a9; text-align: center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($users) && !empty($users))
                                @foreach($users as $user)
                                    <tr>
                                        <td><a href="#">{{ $user->name }}</a></td>
                                        <td>{{ $user->email }}</td>
                                        <td> {{ $user->roleInfo ?  $user->roleInfo->name : \App\Core\Glosary\RoleConfigs::GUEST['DISPLAY'] }} </td>
                                        <td>
                                            <div class="btn-wrapper" style="display: flex; align-items: center;justify-content: center">
                                                <button class="btn btn-primary btn-edit" style="margin-right: 10px"> <a href="{{ route('user.manager.edit', ['id' => $user->id]) }}" style="color: #FFFFFF">  Edit </a></button>
                                                <form action="{{ route( 'user.manager.delete', ['id' => $user->id] ) }}" id="deleteuser{{$user->id}}" method="POST" style="display: inline-block">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger waves-effect waves-light" onclick="deleteUser({{$user->id}})">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="pagination-wrapper">
                                {{ $users->links('backend.elements.pagination') }}
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
        function deleteUser(id) {
            if(confirm("are you sure delete user?"))
                $('#deleteuser'+id).submit();
        }
    </script>
@endsection
