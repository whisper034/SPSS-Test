@php
    $active_sidebar = [
        'Dashboard' => false,
        'Peserta' => false,
        'Lomba' => false,
        'Timeline' => false,
        'User' => false,
        'Notification' => false,
        'Profile' => false
    ];

    if (Request::is('admin/peserta')){
        $active_sidebar['Peserta'] = true;
    }
    else if (Request::is('admin/timeline') || Request::is('admin/timeline/*')){
        $active_sidebar['Timeline'] = true;
    }
    else if (Request::is('admin/user') || Request::is('admin/user/*')){
        $active_sidebar['User'] = true;
    }
    else if (Request::is('admin/lomba')){
        $active_sidebar['Lomba'] = true;
    }
    else if (Request::is('admin/notification')){
        $active_sidebar['Notification'] = true;
    }
    else if (Request::is('admin/profile')){
        $active_sidebar['Profile'] = true;
    }
    else {
        $active_sidebar['Dashboard'] = true;
    }
@endphp

<div class="sidebar">
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li @if ($active_sidebar['Dashboard']) class="active" @endif>
                <a href="/admin">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li @if ($active_sidebar['Peserta']) class="active" @endif>
                <a href="/admin/peserta">
                    <i class="tim-icons icon-notes"></i>
                    <p>Daftar Peserta</p>
                </a>
            </li>
            <li @if ($active_sidebar['Lomba']) class="active" @endif>
                <a href="/admin/lomba">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Peserta Lomba</p>
                </a>
            </li>
            <li @if ($active_sidebar['Timeline']) class="active" @endif>
                <a href="/admin/timeline">
                    <i class="tim-icons icon-calendar-60"></i>
                    <p>Timeline</p>
                </a>
            </li>
            @if (Auth::user()->role_id == 1)
            <li @if ($active_sidebar['User']) class="active" @endif>
                <a href="/admin/user">
                    <i class="far fa-address-book"></i>
                    <p>User Management</p>
                </a>
            </li>
            @endif
            <li @if ($active_sidebar['Notification']) class="active" @endif>
                <a href="/admin/notification">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>Notification</p>
                </a>
            </li>
            <li @if ($active_sidebar['Profile']) class="active" @endif>
                <a href="/admin/profile">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Profile</p>
                </a>
            </li>
        </ul>
    </div>
</div>