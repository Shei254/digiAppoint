<div class="dashboard-header__inner flex-between">
    <div class="dashboard-body__bar d-xl-none d-block">
        <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
    </div>
    <div class="dashboard-header__right flex-align ms-auto">
        <div class="user-info">
            <button class="user-info__button flex-align">               
                <span class="name">{{ auth()->user()->fullname }}</span>
            </button>
            <ul class="user-info-dropdown">
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="{{ route('user.profile.setting') }}">
                        <span class="icon"><i class="las la-user-circle"></i></span>
                        <span class="text">@lang('Profile Setting')</span>
                    </a>
                </li>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="{{ route('user.change.password') }}">
                        <span class="icon"><i class="las la-lock"></i></span>
                        <span class="text">@lang('Change Password')</span>
                    </a>
                </li>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="{{ route('user.logout') }}">
                        <span class="icon"><i class="las la-sign-out-alt"></i></span>
                        <span class="text">@lang('Logout')</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
