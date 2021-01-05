@extends('backend.default')
@section('content')
    <div class="container-fluid">


                <div class="card">
                    <div class="card-body">

                        <h4>
                            <span class="badge badge-primary"> <i class="mdi mdi-key-link"></i> Edit Role</span>
                        </h4>


                        {!! displayAlert(Session::get('message'))  !!}

                        <form class="custom-validation" action="{{ route( 'permission.add' ) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
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
                                </div>
                                <div class="col-lg-4">
                                    <h4 class="card-title">Add permission</h4>

                                    @if( !is_null($permissionGroup) && $permissionGroup->isNotEmpty())
                                    <div id="accordion" class="accordion">

                                        @foreach($permissionGroup as $perGroup)
                                            <div class="card shadow-none border mb-2">
                                                <div class="card-header p-3" id="heading{{ $perGroup->id }}" data-toggle="collapse"
                                                     aria-expanded="true"
                                                     aria-controls="collapse{{ $perGroup->id }}" href="#collapse{{ $perGroup->id }}" style="cursor: pointer">
                                                    <h6 class="m-0">
                                                        <a class="text-dark" >
                                                            {{ $perGroup->name }}
                                                        </a>
                                                        <p style="margin: 0px; font-size: 12px; font-weight: 500">{{ $perGroup->desc }}</p>
                                                    </h6>
                                                    <span>
                                                            <input type="checkbox" id="switch64" switch="primary" checked/>
                                                            <label for="switch64" data-on-label="Yes" data-off-label="No"></label>
                                                    </span>
                                                </div>

                                                <div id="collapse{{ $perGroup->id }}" class="collapse" aria-labelledby="heading{{ $perGroup->id }}" data-parent="#accordion">
                                                    <div class="card-body">

                                                        <div>
                                                            <input type="checkbox" id="switch6" switch="primary" checked/>
                                                            <label for="switch6" data-on-label="Yes" data-off-label="No"></label>
                                                        </div>

                                                        <div>
                                                            <input type="checkbox" id="switch4" switch="primary" checked/>
                                                            <label for="switch6" data-on-label="Yes" data-off-label="No"></label>
                                                        </div>

                                                        <div>
                                                            <input type="checkbox" id="switch3" switch="primary" checked/>
                                                            <label for="switch6" data-on-label="Yes" data-off-label="No"></label>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    </div>

                                    @else
                                        <div class="alert alert-warning mb-0" role="alert">
                                            <h5 class="alert-heading font-size-16">Group permission is empty!</h5>
                                        </div>
                                    @endif

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
        </div>
    </div>
@endsection
