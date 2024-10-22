<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(app()->getLocale() == 'ar') dir="rtl"  @else dir="ltr" @endif>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $settings["app_name"] }}</title>

  
        <meta name="description" content="{{ $settings["meta_description"] ?? 'منصة للتجارة العالمية / GLOBAL TRADE PLATFORM , توفير ، تصنيع ، بحث  وتجهيز كل أنواع السلع والبضائع من الصين الى جميع الدول'}}">
        <meta name="keywords" content="{{ implode(',',$settings["meta_keywords"]) ?? 'شركة TRS,trisoline global company, trisoline, تريزولاين للشحن,import from china, electronic equipment,processing machinery,شركة  trisoline, شراء من الصين,الشحن من الصين' }}">
        <meta name="author" content="{{$settings['app_name']}}">
        <meta name="website" content="https://trisoline.com">
        <meta name="email" content="{{$settings['contact_email']}}">
        <meta name="version" content="2.0.0">

        <meta itemprop="name" content="{{  $settings['app_name'] ?? 'شركة TRS --- شركة TRISOLINE للتجارة العالمية'}}">
        <meta itemprop="description" content="{{ $settings["meta_description"] ?? 'منصة للتجارة العالمية / GLOBAL TRADE PLATFORM , توفير ، تصنيع ، بحث  وتجهيز كل أنواع السلع والبضائع من الصين الى جميع الدول'}}">
        <meta itemprop="image" content="{{ $settings["meta_image"] ? url(asset("storage/".$settings["meta_image"])) : asset('logo.png')}}">

        <meta name="twitter:card" content="product">
        <meta name="twitter:site" content="@publisher_handle">
        <meta name="twitter:title" content="{{  $settings['app_name'] ?? 'شركة TRS --- شركة TRISOLINE للتجارة العالمية'}}">
        <meta name="twitter:description" content="{{ $settings["meta_description"] ?? 'منصة للتجارة العالمية / GLOBAL TRADE PLATFORM , توفير ، تصنيع ، بحث  وتجهيز كل أنواع السلع والبضائع من الصين الى جميع الدول'}}">
        <meta name="twitter:creator" content="@author_handle">
        <meta name="twitter:image" content="{{ $settings["meta_image"] ? url(asset("storage/".$settings["meta_image"])) : asset('logo.png')}}">

        <meta property="og:title" content="{{  $settings['app_name'] ?? 'شركة TRS --- شركة TRISOLINE للتجارة العالمية'}}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://www.trisoline.com" />
        <meta property="og:image" content="{{ $settings["meta_image"] ? url(asset("storage/".$settings["meta_image"])) : asset('logo.png')}}" />
        <meta property="og:description" content="{{ $settings["meta_description"] ?? 'منصة للتجارة العالمية / GLOBAL TRADE PLATFORM , توفير ، تصنيع ، بحث  وتجهيز كل أنواع السلع والبضائع من الصين الى جميع الدول'}}" />
        <meta property="og:site_name" content="{{ $settings["app_name"] }}" />
        <meta property="fb:app_id" content>
        <!-- favicon -->
        <link href="{{ $settings["favicon"] ? asset("storage/".$settings["favicon"]) : asset('favicon.ico')}}" rel="shortcut icon">
        <link rel="icon" href="{{ $settings["favicon"] ? asset("storage/".$settings["favicon"]) : asset('favicon.ico')}}">

        <!-- bing registration service-->
        <meta name="msvalidate.01" content="BDFBD7C7EF3727604D37A7FFE4A7649F" />
        <!-- Css -->
        <link href="{{asset('assets/libs/tobii/css/tobii.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/libs/tiny-slider/tiny-slider.css')}}" rel="stylesheet">
        <!-- Main Css -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/css/line.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.4.47/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{asset('assets/css/tailwind.css')}}">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
       <style>
         *{
                font-family: "Noto Kufi Arabic", sans-serif !important;
                font-optical-sizing: auto;
                font-style: normal;
        }
        .text-theme.btn-link{
            color: #f2c21c;
        }
        .nav-link.underlined{
            text-decoration: underline;
            text-underline-offset: 5px;
        }
        @media(min-width:768px)
        {
        .btn.btn-md{
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 2rem;
            padding-right: 2rem;
            font-size: 1rem;
            line-height: 1.25rem;
        }
        .lg_992\:block{
            display: block !important;
        }
        .lg_992\:mb-7{
            margin-bottom: 1.75rem  !important;
        }
        .md\:px-0{
           padding-right: 0  !important;
           padding-left: 0  !important;
        }
        }
        .label .ball{
            height: 1.3rem !important;
            width: 1.3rem;
            top: 3px !important;
        }
        .my-2{margin-top: 0.5rem !important;
            margin-bottom: 0.75rem !important;}
        .w-38{width: 11rem !important;}
        .w-36{width: 9rem !important;}
        .w-26{width: 6.5rem !important;}
        .ltr\:w-22:where([dir="ltr"], [dir="ltr"] *){width: 5.5rem !important;}
        .ltr\:w-40:where([dir="ltr"], [dir="ltr"] *){width: 11.5rem !important;}
        .ltr\:w-37:where([dir="ltr"], [dir="ltr"] *){width: 9.5rem !important;}
        .ltr\:w-37:where([dir="ltr"], [dir="ltr"] *){width: 9.5rem !important;}
        .ltr\:w-12:where([dir="ltr"], [dir="ltr"] *){width: 3rem !important;}
        .ltr\:w-32:where([dir="ltr"], [dir="ltr"] *){width: 8rem !important;}
        .text-justify{text-align: justify !important}
        .text-right{text-align: right !important}
        .rotate-180{
            -webkit-transform: scaleX(-1);
            -moz-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            transform: scaleX(-1);
            }
       </style>
       @yield('styles')
        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-rubik text-base text-slate-900 dark:text-white dark:bg-slate-900">

           @include('layouts.navigation_menu')

            <!-- Page Heading -->
            {{-- @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif --}}
            @yield('content')

            @include('layouts.footer')
         <!-- Back to top -->
         <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fixed hidden text-lg rounded-full z-10 bottom-5 end-5 h-9 w-9 text-center bg-hoverTheme text-white leading-9"><i class="uil uil-arrow-up"></i></a>
         <!-- Back to top -->
 
         <!-- Switcher -->
         <div class="fixed top-1/4 -right-2 z-3  hidden lg_992:block">
             <span class="relative inline-block rotate-90">
                 <input type="checkbox" class="checkbox opacity-0 absolute" id="chk" />
                 <label class="label bg-slate-900 dark:bg-white shadow dark:shadow-gray-800 cursor-pointer rounded-full flex justify-between items-center p-1 w-14 h-8" for="chk">
                     <i class="uil uil-moon text-[20px] text-yellow-500"></i>
                     <i class="uil uil-sun text-[20px] text-yellow-500"></i>
                     <span class="ball bg-white dark:bg-slate-900 rounded-full absolute top-[2px] left-[2px] w-7 h-7"></span>
                 </label>
             </span>
         </div>
         <!-- Switcher -->
 
         <!-- LTR & RTL Mode Code -->
         <div class="fixed top-1/3 -right-3 z-50  hidden lg_992:block">
            @if(app()->getLocale() =="ar")

             <a href="{{route('change_locale',"en")}}" id="switchRtl">
                 <span class="py-1 px-3 relative inline-block rounded-t-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-800 font-semibold rtl:block " >English</span>
             </a>
             @else
             <a href="{{route('change_locale',"ar")}}" id="switchRtl">
                 <span class="py-1 px-3 relative inline-block rounded-t-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-800 font-semibold ltr:block ">Arabic</span>
                
             </a>
              @endif
         </div>      

        @stack('modals')

        @livewireScripts
        
        <!-- JAVASCRIPTS -->
        <script src="{{asset('assets/libs/gumshoejs/gumshoe.polyfills.min.js')}}"></script>
        <script src="{{asset('assets/libs/tobii/js/tobii.min.js')}}"></script>
        <script src="{{asset('assets/libs/tiny-slider/min/tiny-slider.js')}}"></script>
        <script src="{{asset('assets/js/plugins.init.js')}}"></script>
        <script src="{{asset('assets/js/app.js')}}"></script>
        @yield('scripts')
    </body>
</html>