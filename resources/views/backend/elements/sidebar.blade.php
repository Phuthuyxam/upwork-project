<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="#" class="waves-effect">
                        <i class="dripicons-device-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(PermissionHelpers::canAccess(route('filemanager.index')))
                    <li>
                        <a href="{{route('filemanager.index')}}" class="waves-effect">
                            <i class="dripicons-photo-group"></i>
                            <span>Gallery</span>
                        </a>
                    </li>
                @endif

                @if(PermissionHelpers::canAccess(route('page.index')))
                    <li>
                        <a href="javascript: void(0);" class="waves-effect has-arrow">
                            <i class="dripicons-checklist"></i>
                            <span> Pages </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if(PermissionHelpers::canAccess(route('page.add')))
                                <li><a href="{{ route('page.add') }}">Create</a></li>
                            @endif
                            @if(PermissionHelpers::canAccess(route('taxonomy.index')))
                                <li><a href="{{ route('taxonomy.index') }}" class="waves-effect">Brands</a></li>
                            @endif
                            @if(PermissionHelpers::canAccess(route('page.index')))
                                <li><a href="{{ route('page.index') }}">All Pages</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(PermissionHelpers::canAccess(route('post.add'))
                    || PermissionHelpers::canAccess(route('post.index')) )
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-home"></i>
                        <span> Hotels </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(PermissionHelpers::canAccess(route('post.add')))
                        <li><a href="{{ route('post.add') }}">Create</a></li>
                        @endif
                        @if(PermissionHelpers::canAccess(route('post.index')))
                            <li><a href="{{ route('post.index') }}">All Hotels</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(PermissionHelpers::canAccess(route('post.add',\App\Core\Glosary\PostType::PAGE['NAME']))
                    || PermissionHelpers::canAccess(route('page.index')) )
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-stack"></i>
                        <span> Services </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(PermissionHelpers::canAccess(route('post.add',\App\Core\Glosary\PostType::PAGE['NAME'])))
                            <li><a href="{{ route('page.add',\App\Core\Glosary\PostType::PAGE['NAME'])}}">Create</a></li>
                        @endif
                        @if(PermissionHelpers::canAccess(route('post.index')))
                            <li><a href="{{ route('page.index') }}">All Services</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(PermissionHelpers::canAccess(route('user.manager.index'))
                    || PermissionHelpers::canAccess(route('permission.index')) )
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-user"></i>
                        <span>Users & Roles</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(PermissionHelpers::canAccess(route('user.manager.index')))
                            <li><a href="{{ route('user.manager.index') }}">Users</a></li>
                        @endif
                        @if(PermissionHelpers::canAccess(route('permission.index')))
                            <li><a href="{{ route('permission.index') }}">Roles</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                <li class="menu-title">General settings</li>
                <li>
                    <a href="#" class="waves-effect">
                        <i class="dripicons-device-desktop"></i>
                        <span>Logo</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
