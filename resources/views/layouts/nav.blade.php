<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item  @if($page == 'main') kt-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ route('index') }}" class="kt-menu__link">
                    <i class="kt-menu__link-icon flaticon2-architecture-and-city"></i>
                    <span class="kt-menu__link-text">{{ __('pages.main') }}</span>
                </a>
            </li>
            <li class="kt-menu__item kt-menu__item--submenu @if(($partition ?? '') == 'balance') kt-menu__item--active kt-menu__item--open kt-menu__item--here @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon fa fa-ruble-sign"></i>
                    <span class="kt-menu__link-text">{{ __('pages.balance') }}</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item @if($page == 'balance.index') kt-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('balance.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet flaticon-piggy-bank"><span>&nbsp;</span></i>
                                <span class="kt-menu__link-text">{{ __('pages.make-payment') }}</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if($page == 'rates.index') kt-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('rates.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet flaticon2-shopping-cart-1"><span>&nbsp;</span></i>
                                <span class="kt-menu__link-text">{{ __('pages.buy-rates') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="kt-menu__item kt-menu__item--submenu @if(($partition ?? '') == 'schedule') kt-menu__item--active kt-menu__item--open kt-menu__item--here @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon-calendar-1"></i>
                    <span class="kt-menu__link-text">{{ __('pages.schedule') }}</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item @if($page == 'schedule.find_teacher_time') kt-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('schedule.find_teacher_time') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet flaticon-clock-2"><span>&nbsp;</span></i>
                                <span class="kt-menu__link-text">{{ __('pages.schedule.find_teacher_time') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
{{--                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>--}}
{{--                    <ul class="kt-menu__subnav">--}}
{{--                        <li class="kt-menu__item @if($page == 'schedule.absent_period') kt-menu__item--active @endif" aria-haspopup="true">--}}
{{--                            <a href="{{ route('schedule.absent_period') }}" class="kt-menu__link ">--}}
{{--                                <i class="kt-menu__link-bullet flaticon-clock-2"><span>&nbsp;</span></i>--}}
{{--                                <span class="kt-menu__link-text">{{ __('pages.schedule.absent_period') }}</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
            </li>
            <li class="kt-menu__item kt-menu__item--submenu @if(($partition ?? '') == 'faq') kt-menu__item--active kt-menu__item--open kt-menu__item--here @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon fa flaticon-info"></i>
                    <span class="kt-menu__link-text">{{ __('pages.faq') }}</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item @if($page == 'faq.index') kt-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('faq.index') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet flaticon-notes"><span>&nbsp;</span></i>
                                <span class="kt-menu__link-text">{{ __('pages.faq-info') }}</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if($page == 'faq.feedback') kt-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{ route('faq.feedback') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-bullet flaticon-speech-bubble"><span>&nbsp;</span></i>
                                <span class="kt-menu__link-text">{{ __('pages.faq-feedback') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
