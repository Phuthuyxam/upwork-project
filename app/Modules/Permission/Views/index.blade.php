@extends('backend.default')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">

            <div class="card">
                <div class="card-body">

                    <h4>
                        <span class="badge badge-primary"> <i class="mdi mdi-key-plus"></i> Add Roles</span>
                    </h4>

                    <form class="custom-validation" action="{{ route( 'permission.add' ) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="role_name" required  placeholder="Type something" value="{{ old('role_name') }}" />
                            @if($errors->first('role_name')) {!! '<p style="color: red"> '. $errors->first('role_name') .' </p>' !!} @endif
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <div>
                                <textarea class="form-control" name="role_desc" rows="5">{{ old('role_desc') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-pink waves-effect waves-light">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect ml-1">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Role list</h4>
                    <p class="card-title-desc">
                        Manage all Roles
                    </p>
                    {!! displayAlert(Session::get('message'))  !!}
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $key => $role)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $role->name  }}</td>
                                    <td>{{ $role->desc }}</td>
                                    <td>
                                        <div class="button-items">
                                            <button type="button" class="btn btn-primary waves-effect waves-light"><a href="{{ route('permission.edit',['id' => $role->id]) }}" style="color: #ffffff"> Edit/Add Permissions </a></button>
                                            <form action="{{ route( 'permission.delete', ['id' => $role->id] ) }}" id="deleterole{{$role->id}}" method="POST" style="display: inline-block">
                                                @csrf
                                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="deleteRole({{$role->id}})">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function deleteRole(id) {
            if(confirm("are you sure delete role?"))
                $('#deleterole'+id).submit();
        }
    </script>
@endsection
