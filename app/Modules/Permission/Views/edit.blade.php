@extends('backend.default')

@section('style')
    <style>
        .permission-group-head {
            display: flex;
            align-items: center;
        }
        .permission-group-head label {
            margin: 0;
        }
        .permission-group-head span {
            line-height: unset;
            margin-left: auto;
            order: 2;
        }
        .checkbox-permission {
            display: flex;
            align-items: center;
        }
        .checkbox-permission input{
            margin-right: 5px;
        }
        .checkbox-permission p {
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">


                <div class="card">
                    <div class="card-body">

                        <h4>
                            <span class="badge badge-primary"> <i class="mdi mdi-key-link"></i> Edit Role</span>
                        </h4>

                        <div class="row">
                            <div class="col-lg-8">
                                {!! displayAlert(Session::get('message'))  !!}
                            </div>
                        </div>

                        <form class="custom-validation" id="edit-permission-form" action="{{ route('permission.save',['id' => $role->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="role_name" required placeholder="Type something" value="{{ old('role_name', $role->name) }}" />
                                        @if($errors->first('role_name')) {!! '<p style="color: red"> '. $errors->first('role_name') .' </p>' !!} @endif
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <div>
                                            <textarea class="form-control" name="role_desc" rows="5">{{ old('role_desc', $role->desc) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h4 class="card-title">Add permission</h4>

                                    @if( !is_null($permissionGroup) && $permissionGroup->isNotEmpty())
                                    <div id="accordion" class="accordion">

                                        @foreach($permissionGroup as $perGroup)
                                            <div class="card shadow-none border mb-2">
                                                <div class="card-header p-3 permission-group-head" id="heading{{ $perGroup->id }}" data-toggle="collapse"
                                                     aria-expanded="true"
                                                     aria-controls="collapse{{ $perGroup->id }}" href="#collapse{{ $perGroup->id }}" style="cursor: pointer">
                                                    <h6 class="m-0">
                                                        <a class="text-dark" >
                                                            {{ $perGroup->name }}
                                                        </a>
                                                        <p style="margin: 0px; font-size: 12px; font-weight: 500">{{ $perGroup->desc }}</p>
                                                    </h6>
                                                    <span>
                                                            <input type="checkbox" id="switchGroup{{$perGroup->id}}"
                                                                   class="checkbox-permission-group" data-id="{{ $perGroup->id }}"
                                                                   onchange="acceptAllGroup({{ $perGroup->id }})"
                                                                   {{ in_array($perGroup->id, $rolePermission['group']) ? 'checked' : false }} switch="primary"/>
                                                            <label for="switchGroup{{$perGroup->id}}" id="labelGroup{{$perGroup->id}}" data-on-label="All" data-off-label="No"></label>
                                                    </span>
                                                </div>
                                                @if($perGroup->permission)
                                                    <div id="collapse{{ $perGroup->id }}" class="collapse show" aria-labelledby="heading{{ $perGroup->id }}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @foreach($perGroup->permission as $permission)
                                                                <div class="col-lg-4">
                                                                    <div class="checkbox-permission">
                                                                        <input type="checkbox"
                                                                               id="switchPermission{{ $permission->id }}"
                                                                               class="checkbox-permission-input"
                                                                               data-id="{{ $permission->id }}" data-group="{{$perGroup->id}}"
                                                                               onchange="setAcceptAllGroup({{ $perGroup->id }})"
                                                                                {{ ( in_array($permission->id, $rolePermission['permission']) || in_array($perGroup->id, $rolePermission['group']) )  ? 'checked' : false }}/>
                                                                        <p>{{ $permission->name }}</p>
                                                                    </div>
                                                                    @if($permission->desc) <p>( {{ $permission->desc }} )</p> @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
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
                            <input type="hidden" name="permission_group" id="hidden-permission_group">
                            <input type="hidden" name="permission" id="hidden-permission">
                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-pink waves-effect waves-light" onclick="setValueHidden(event)">
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

@section('script')
    <script>
        function setValuePermissionSwitch(id , value) {
            if(value === 'checked') {
                $('#switchPermission'+id).prop('checked', true);
            }
            if(value === 'unchecked') {
                $('#switchPermission'+id).prop('checked', false);
            }
        }
        function acceptAllGroup( id ) {
            // set check all
            $('#collapse'+id).find('.checkbox-permission-input').each(function (item) {
                var permissionId = $(this).data('id');
                var status = $('#switchGroup' + id).is(":checked") ? 'checked' : 'unchecked';
                setValuePermissionSwitch(permissionId,status);
            })
        }

        function setAcceptAllGroup(id) {
            var checker = true;
            $('#collapse'+id).find('.checkbox-permission-input').each(function (item) {
                if(!$(this).is(":checked")) {
                    checker = false;
                    return false;
                }
            })
            if(checker === true) {
                $('#switchGroup'+id).prop('checked', true);
            }else {
                $('#switchGroup'+id).prop('checked', false);
            }
        }

        function setValueHidden(event) {
            event.preventDefault();
            // add value to permission group
            var permission_group = [];
            var permissons = [];
            $('.checkbox-permission-group').each(function (item) {
                if($(this).is(':checked')) {
                    var id = $(this).data('id');
                    permission_group.push(id);
                }
            });

            $('.checkbox-permission-input').each(function (item) {
                if($(this).is(':checked')) {
                    var group = $(this).data('group');
                    var id = $(this).data('id')
                    if( !permission_group.includes(group) )
                        permissons.push(id);
                }
            });
            $('#hidden-permission_group').val(permission_group);
            $('#hidden-permission').val(permissons);
            $('#edit-permission-form').submit();
        }



    </script>
@endsection
