@php
    $current_page = Route::currentRouteName();
@endphp

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-h-square"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @role(['editor'])
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        @permission('main')
        <a class="nav-link" href="{{route('admin.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        @endpermission
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    @permission('manage_posts')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOn"
           aria-expanded="true" aria-controls="collapseOn">
            <i class="fas fa-newspaper"></i>
            <span>Posts</span>
        </a>
        <div id="collapseOn" class="collapse" aria-labelledby="headingOn" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @permission('show_posts')
                <a class="collapse-item" href="{{ route('admin.posts.index') }}">Show</a>
                @endpermission
                @permission('create_posts')
                <a class="collapse-item" href="{{ route('admin.posts.create') }}">Create</a>
                @endpermission
            </div>
        </div>
    </li>
    @endpermission

    @permission('manage_post_categories')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
           aria-expanded="true" aria-controls="collapseCategories">
            <i class="fas fa-newspaper"></i>
            <span>Categories</span>
        </a>
        <div id="collapseCategories" class="collapse" aria-labelledby="headingCategories" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @permission('show_post_categories')
                <a class="collapse-item" href="{{ route('admin.post_categories.index') }}">Show</a>
                @endpermission
                @permission('create_post_categories')
                <a class="collapse-item" href="{{ route('admin.post_categories.create') }}">Create</a>
                @endpermission
            </div>
        </div>
    </li>
    @endpermission

    @permission('manage_post_tags')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTags"
           aria-expanded="true" aria-controls="collapseTags">
            <i class="fas fa-newspaper"></i>
            <span>Tags</span>
        </a>
        <div id="collapseTags" class="collapse" aria-labelledby="headingTags" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @permission('show_post_tags')
                <a class="collapse-item" href="{{ route('admin.post_tags.index') }}">Show</a>
                @endpermission
                @permission('create_post_tags')
                <a class="collapse-item" href="{{ route('admin.post_tags.create') }}">Create</a>
                @endpermission
            </div>
        </div>
    </li>
    @endpermission

    @permission('manage_post_comments')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-newspaper"></i>
            <span>Comments</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @permission('show_post_comments')
                <a class="collapse-item" href="{{ route('admin.post_comments.index') }}">Show</a>
                @endpermission
            </div>
        </div>
    </li>
    @endpermission

    @permission('manage_pages')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
           aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-file"></i>
            <span>Pages</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @permission('show_pages')
                <a class="collapse-item" href="{{ route('admin.pages.index') }}">Show</a>
                @endpermission
                @permission('create_pages')
                <a class="collapse-item" href="{{ route('admin.pages.create') }}">Create</a>
                @endpermission
            </div>
        </div>
    </li>
    @endpermission

    @permission('manage_users')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
           aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-user"></i>
            <span>Users</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingUser" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @permission('show_users')
                <a class="collapse-item" href="{{ route('admin.users.index') }}">Show</a>
                @endpermission
                @permission('create_users')
                <a class="collapse-item" href="{{ route('admin.users.create') }}">Create</a>
                @endpermission
            </div>
        </div>
    </li>
    @endpermission

    @permission('manage_contact_us')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContact"
           aria-expanded="true" aria-controls="collapseContact">
            <i class="fas fa-envelope"></i>
            <span>Contact Us</span>
        </a>
        <div id="collapseContact" class="collapse" aria-labelledby="headingContact" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @permission('show_contact_us')
                <a class="collapse-item" href="{{ route('admin.contact_us.index') }}">Show</a>
                @endpermission
            </div>
        </div>
    </li>
    @endpermission

    @endrole

    @role(['admin'])
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-folder"></i>
            <span>Posts</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.posts.index') }}">Posts</a>
                <a class="collapse-item" href="{{ route('admin.post_comments.index') }}">Comments</a>
                <a class="collapse-item" href="{{ route('admin.post_categories.index') }}">Categories</a>
                <a class="collapse-item" href="{{ route('admin.post_tags.index') }}">tags</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.pages.index') }}">
            <i class="fas fa-file"></i>
            <span>Pages</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-user"></i>
            <span>Users</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.contact_us.index') }}">
            <i class="fas fa-envelope"></i>
            <span>Contact Us</span></a>
    </li>
    @endrole
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
