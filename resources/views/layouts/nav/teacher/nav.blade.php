<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1">
        <ul class="kt-menu__nav">
            <li class="kt-menu__item @if(($partition ?? '') == 'main') kt-menu__item--active kt-menu__item--open kt-menu__item--here @endif" aria-haspopup="true">
                <a href="{{ route('teacher.index') }}" class="kt-menu__link">
                    <i class="kt-menu__link-icon flaticon2-architecture-and-city"></i>
                    <span class="kt-menu__link-text">{{ __('pages.main') }}</span>
                </a>
            </li>

            <li class="kt-menu__item @if(($partition ?? '') == 'schedule') kt-menu__item--active kt-menu__item--open kt-menu__item--here @endif" aria-haspopup="true">
                <a href="#" class="kt-menu__link">
                    <i class="kt-menu__link-icon flaticon-event-calendar-symbol"></i>
                    <span class="kt-menu__link-text">{{ __('pages.schedule') }}</span>
                </a>
            </li>

            <li class="kt-menu__item" aria-haspopup="true">
                <a href="{{ route('login.logout') }}" class="kt-menu__link">
                    <i class="kt-menu__link-icon fa fa-user-alt-slash"></i>
                    <span class="kt-menu__link-text">{{ __('login.sign-out-btn') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
