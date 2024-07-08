<div class="sidebar-menu__inner">
    <span class="sidebar-menu__close d-xl-none d-block"><i class="fas fa-times"></i></span>
    <div class="sidebar-logo">
        <a href="{{ route('home') }}" class="sidebar-logo__link"><img src="{{ siteLogo('base') }}" alt="image"></a>
    </div>
    <ul class="sidebar-menu-list">
        <li class="sidebar-menu-list__item {{ menuActive('user.home') }}">
            <a href="{{ route('user.home') }}" class="sidebar-menu-list__link">
                <span class="icon"><i class="icon-dashboard"></i></span>
                <span class="text">@lang('Dashboard')</span>
            </a>
        </li>
        @php
            $user = auth()->user();
        @endphp
        <li class="sidebar-menu-list__item {{ menuActive('user.appointment.*') }}">
            <a href="{{ route('user.appointment.index') }}" class="sidebar-menu-list__link">
                <span class="icon"><i class="las la-file-invoice"></i></span>
                <span class="text">@lang('Manage Appointment')</span>
            </a>
        </li>
        @if (!$user->is_staff)
            <li class="sidebar-menu-list__item {{ menuActive('user.staff.*') }}">
                <a href="{{ route('user.staff.list') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-users"></i></span>
                    <span class="text">@lang('Manage Staff')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('user.pricing') }}">
                <a href="{{ route('user.pricing') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="icon-calendar-04"></i></span>
                    <span class="text">@lang('Purchase Plan')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item {{ menuActive('user.deposit.history') }}">
                <a href="{{ route('user.deposit.history') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-history"></i></span>
                    <span class="text">@lang('Payment History')</span>
                </a>
            </li>
        @endif
        <li class="sidebar-menu-list__item {{ menuActive('ticket.index') }}">
            <a href="{{ route('ticket.index') }}" class="sidebar-menu-list__link">
                <span class="icon"><i class="la la-ticket"></i></span>
                <span class="text">@lang('Support Ticket')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.profile.setting') }}">
            <a href="{{ route('user.profile.setting') }}" class="sidebar-menu-list__link">
                <span class="icon"><i class="la la-user-circle"></i></span>
                <span class="text">@lang('Profile Setting')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.change.password') }}">
            <a href="{{ route('user.change.password') }}" class="sidebar-menu-list__link">
                <span class="icon"><i class="la la-lock"></i></span>
                <span class="text">@lang('Change Password')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item">
            <a href="{{ route('user.logout') }}" class="sidebar-menu-list__link">
                <span class="icon"><i class="icon-logout"></i></span>
                <span class="text">@lang('Log Out')</span>
            </a>
        </li>
    </ul>
</div>
