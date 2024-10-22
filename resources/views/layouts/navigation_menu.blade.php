<nav class="navbar" id="navbar">
    <div class="container flex flex-wrap items-center justify-between">
        <a class="navbar-brand" href="{{route('home')}}">
            <span class="inline-block dark:hidden">
                <img src="{{asset($settings["app_logo"])}}" style="height:50px" class="l-dark" alt="">
                <img src="{{asset($settings["app_logo"])}}" style="height:50px" class="l-light" alt="">
            </span>
            <img src="{{asset($settings["app_logo"])}}" style="height:50px" class="hidden dark:inline-block" alt="">
        </a>

        <div class="nav-icons lg_992:hidden flex items-center lg_992:order-1 ms-auto">
            <!-- Navbar Button -->
             {{--<ul class="list-none menu-social mb-0">
                <li class="inline">
                    <a target="_blank" href="https://www.facebook.com/trisoline">
                        <span class="login-btn-primary"><span class="btn btn-sm btn-icon rounded-full bg-[#017cda] hover:bg-hoverTheme border-theme hover:border-hoverTheme text-white"><i class="uil uil-facebook-f"></i></span></span>
                        <span class="login-btn-light"><span class="btn btn-sm btn-icon rounded-full bg-gray-50 hover:bg-gray-200 dark:bg-slate-900 dark:hover:bg-gray-700 hover:border-gray-100 dark:border-gray-700 dark:hover:border-gray-700"><i class="uil uil-facebook-f"></i></span></span>
                    </a>
                </li>
                <li class="inline">
                    <a target="_blank" href="https://x.com/TrisolineGlobal">
                        <span class="login-btn-primary"><span class="btn btn-sm btn-icon rounded-full bg-[#017cda] hover:bg-hoverTheme border-theme hover:border-hoverTheme text-white"><i class="uil uil-twitter"></i></span></span>
                        <span class="login-btn-light"><span class="btn btn-sm btn-icon rounded-full bg-gray-50 hover:bg-gray-200 dark:bg-slate-900 dark:hover:bg-gray-700 hover:border-gray-100 dark:border-gray-700 dark:hover:border-gray-700"><i class="uil uil-twitter"></i></span></span>
                    </a>
                </li> 
                <li class="inline">
                    <a target="_blank" href="https://instagram.com/trisoline_global">
                        <span class="login-btn-primary"><span class="btn btn-sm btn-icon rounded-full bg-[#017cda] hover:bg-hoverTheme border-theme hover:border-hoverTheme text-white"><i class="uil uil-instagram"></i></span></span>
                        <span class="login-btn-light"><span class="btn btn-sm btn-icon rounded-full bg-gray-50 hover:bg-gray-200 dark:bg-slate-900 dark:hover:bg-gray-700 hover:border-gray-100 dark:border-gray-700 dark:hover:border-gray-700"><i class="uil uil-instagram"></i></span></span>
                    </a>
                </li>
             
            </ul>--}}
            <!-- Navbar Collapse Manu Button -->
            {{-- <button data-collapse="menu-collapse" type="button" class="collapse-btn inline-flex items-center ms-3 text-dark dark:text-white lg_992:hidden" aria-controls="menu-collapse" aria-expanded="false">
                <span class="sr-only">Navigation Menu</span>
                <i class="mdi mdi-menu mdi-24px"></i>
            </button> --}}
        
            <ul class="navbar-nav nav-light" id="navbar-navlist">
                @if(app()->getLocale() =="ar")                  
                <li class="nav-item">
                    <a class="nav-link underlined" href="{{route('change_locale',"en")}}">English</a>
                </li>   
                @else
                <li class="nav-item">
                    <a class="nav-link underlined" href="{{route('change_locale',"ar")}}">Arabic</a>
                </li>   
                @endif
               
            </ul>
            <span class="relative inline-block ms-3">
                <input type="checkbox" class="checkbox opacity-0 absolute" id="chk" />
                <label class="label bg-slate-900 dark:bg-white shadow dark:shadow-gray-800 cursor-pointer rounded-full flex justify-between items-center p-1 w-12 h-7" for="chk">
                    <i class="uil uil-moon text-[20px] text-yellow-500"></i>
                    <i class="uil uil-sun text-[20px] text-yellow-500"></i>
                    <span class="ball bg-white dark:bg-slate-900 rounded-full absolute top-[2px] left-[2px]"></span>
                </label>
            </span>
        </div>

        <!-- Navbar Manu -->
        <div class="navigation lg_992:order-1 lg_992:flex hidden" id="menu-collapse">
            <ul class="navbar-nav nav-light" id="navbar-navlist">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">{{ trans('landing.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">{{ trans('landing.about_us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">{{ trans('landing.our_services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#portfolio">{{ trans('landing.portfolio') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testi">{{ trans('landing.testimonials') }}</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="#contact">{{ trans('landing.contact_us') }}</a>
                </li>     
               
                @if(app()->getLocale() =="ar")                  
                <li class="nav-item">
                    <a class="nav-link underlined" href="{{route('change_locale',"en")}}">English</a>
                </li>   
                @else
                <li class="nav-item">
                    <a class="nav-link underlined" href="{{route('change_locale',"ar")}}">Arabic</a>
                </li>   
                @endif
                @if(!auth()->check())
                <li class="nav-item">
                    <a class="nav-link  btn btn-sm btn-md btn bg-theme hover:bg-hoverTheme border-theme hover:border-hoverTheme text-white rounded-md" href="{{route('filament.client.auth.login')}}">{{ trans('landing.login') }}</a>
                </li>
                @else 
                <li class="nav-item">
                    <a class="nav-link  btn btn-sm btn-md btn bg-theme hover:bg-hoverTheme border-theme hover:border-hoverTheme text-white rounded-md" href="{{route('filament.client.pages.dashboard')}}">{{ trans('landing.dashboard') }}</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>