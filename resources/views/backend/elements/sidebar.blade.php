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

                <li>
                    <a href="{{route('filemanager.index')}}" class="waves-effect">
                        <i class="dripicons-photo-group"></i>
                        <span>Gallery</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('taxonomy.index') }}" class="waves-effect">
                        <i class="dripicons-checklist"></i>
                        <span> Categories </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-home"></i>
                        <span> Hotels </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('post.add',\App\Core\Glosary\PostType::HOTEL['NAME']) }}">Create</a></li>
                        <li><a href="{{ route('post.index') }}">All Hotels</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-stack"></i>
                        <span> Services </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('post.add',\App\Core\Glosary\PostType::SERVICE['NAME'])}}">Create</a></li>
                        <li><a href="{{ route('post.index') }}">All Services</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-user"></i>
                        <span>Users & Roles</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('user.manager.index') }}">Users</a></li>
                        <li><a href="{{ route('permission.index') }}">Roles</a></li>
                    </ul>
                </li>
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
