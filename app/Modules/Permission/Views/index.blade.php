@extends('backend.default')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">

            <div class="card">
                <div class="card-body">

                    <h4>
                        <span class="badge badge-primary"> <i class="mdi mdi-key-plus"></i> Add Permission</span>
                    </h4>


                    {!! displayAlert(Session::get('message'))  !!}

                    <form class="custom-validation" action="{{ route( 'permission.add' ) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="role_name"  placeholder="Type something" value="{{ old('role_name') }}" />
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

                    <h4 class="card-title">Permisson list</h4>
                    <p class="card-title-desc">
                        manager all permission
                    </p>

                    <div class="table-responsive">
                        <table class="table table-dark table-borderless">
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
                                            <button type="button" class="btn btn-primary waves-effect waves-light"><a href="{{ route('permission.edit',['id' => $role->id]) }}" style="color: #ffffff"> Edit </a></button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light">Delete</button>
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
