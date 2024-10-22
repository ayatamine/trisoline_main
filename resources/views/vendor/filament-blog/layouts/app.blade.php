<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        @php
        $settings =  \App\Models\Setting::select( 'app_name',
        'app_logo',
        'phone_number',
        'address',
        'contact_email',
        'facebook_link',
        'youtube_link',
        'instagram_link',
        'linkedin_link',
        'twitter_link',
        'meta_title',
        'meta_image',
        'favicon',
        'meta_description',
        'meta_keywords'
        )->first()->toArray();
    @endphp
    <title>{{ $settings["app_name"] }}</title>

  
    <meta name="description" content="{{ $settings["meta_description"] ?? 'منصة للتجارة العالمية / GLOBAL TRADE PLATFORM , توفير ، تصنيع ، بحث  وتجهيز كل أنواع السلع والبضائع من الصين الى جميع الدول'}}">
    <meta name="keywords" content="{{ implode(',',$settings["meta_keywords"]) ?? 'شركة TRS,trisoline global company, trisoline, تريزولاين للشحن,import from china, electronic equipment,processing machinery,شركة  trisoline, شراء من الصين,الشحن من الصين' }}">
    <meta name="author" content="{{$settings['app_name']}}">
    <meta name="website" content="https://trisoline.com">
    <meta name="email" content="{{$settings['contact_email']}}">
    <meta name="version" content="2.0.0">

    <meta itemprop="name" content="{{  $settings['app_name'] ?? 'شركة TRS --- شركة TRISOLINE للتجارة العالمية'}}>
    <meta itemprop="description" content="{{ $settings["meta_description"] ?? 'منصة للتجارة العالمية / GLOBAL TRADE PLATFORM , توفير ، تصنيع ، بحث  وتجهيز كل أنواع السلع والبضائع من الصين الى جميع الدول'}}">
    <meta itemprop="image" content="{{ $settings["meta_image"] ? asset("storage/".$settings["meta_image"]) : asset('logo.png')}}">

    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{  $settings['app_name'] ?? 'شركة TRS --- شركة TRISOLINE للتجارة العالمية'}}>
    <meta name="twitter:description" content="{{ $settings["meta_description"] ?? 'منصة للتجارة العالمية / GLOBAL TRADE PLATFORM , توفير ، تصنيع ، بحث  وتجهيز كل أنواع السلع والبضائع من الصين الى جميع الدول'}}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ $settings["meta_image"] ? asset("storage/".$settings["meta_image"]) : asset('logo.png')}}">

    <meta property="og:title" content="{{  $settings['app_name'] ?? 'شركة TRS --- شركة TRISOLINE للتجارة العالمية'}} />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.trisoline.com" />
    <meta property="og:image" content="{{ $settings["meta_image"] ? asset("storage/".$settings["meta_image"]) : asset('logo.png')}}" />
    <meta property="og:description" content="{{ $settings["meta_description"] ?? 'منصة للتجارة العالمية / GLOBAL TRADE PLATFORM , توفير ، تصنيع ، بحث  وتجهيز كل أنواع السلع والبضائع من الصين الى جميع الدول'}}" />
    <meta property="og:site_name" content="{{ $settings["app_name"] }}" />
    <meta property="fb:app_id" content>
    <!-- favicon -->
    <link href="{{ $settings["favicon"] ? asset("storage/".$settings["favicon"]) : asset('favicon.ico')}}" rel="shortcut icon">
    <link rel="icon" href="{{ $settings["favicon"] ? asset("storage/".$settings["favicon"]) : asset('favicon.ico')}}">

    <!-- Css -->
    <link href="{{asset('assets/libs/tobii/css/tobii.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/libs/tiny-slider/tiny-slider.css')}}" rel="stylesheet">
    <!-- Main Css -->
    <link href="{{asset('assets/libs/@iconscout/unicons/css/line.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('assets/libs/@mdi/font/css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">

    {!! \Firefly\FilamentBlog\Facades\SEOMeta::generate() !!}
    {!! $setting?->google_console_code !!}
    {!! $setting?->google_analytic_code !!}
    {!! $setting?->google_adsense_code !!}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                container: {
                    padding: '2rem',
                    screen: {
                        '2xl': '1200px'
                    }
                },
                extend: {
                    colors: {
                        'primary': {
                            DEFAULT: '#FDAE4B',
                            50: '#fff9f5',
                            100: '#FFF7EC',
                            200: '#FEE4C4',
                            300: '#FED29C',
                            400: '#FDC073',
                            500: '#FDAE4B',
                            600: '#FC9514',
                            700: '#D57802',
                            800: '#9E5902',
                            900: '#663901',
                            950: '#4B2A01'
                        },
                        'rum': {
                            DEFAULT: '#6C6489',
                            50: '#FFFFFF',
                            100: '#FFFFFF',
                            200: '#F0EFF3',
                            300: '#D9D7E2',
                            400: '#C3C0D1',
                            500: '#ADA8BF',
                            600: '#9790AE',
                            700: '#81799D',
                            800: '#6C6489',
                            900: '#524C69',
                            950: '#464058'
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: "Noto Kufi Arabic", sans-serif !important;
                font-optical-sizing: auto;
                font-style: normal;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
    </style>
    <style>
        /* Blog Posts */
        article h1 {
            line-height: 1.2;
            font-size: 2rem;
            color: #424242;
            font-weight: 900;
            padding-bottom: 20px;
        }

        article h2 {
            line-height: 1.2;
            font-size: 1.5rem;
            color: #424242;
            font-weight: 800;
            padding-bottom: 10px;
        }

        article h3 {
            line-height: 1.2;
            font-size: 1.25rem;
            color: #424242;
            font-weight: 700;
            padding-bottom: 10px;
        }

        article h4 {
            line-height: 1.2;
            font-size: 1.2rem;
            color: #424242;
            font-weight: 600;
            padding-bottom: 10px;
        }

        article p {
            line-height: 1.75;
            letter-spacing: .2px;
            font-size: 1rem;
            color: #424242;
            font-weight: 400;
            margin-bottom: 1rem;
        }

        article ul {
            line-height: 1.7;
            padding-bottom: 5px;
        }

        article table {
            margin-top: 2rem;
            margin-bottom: 2rem;
            border-radius: 10px;
        }

        article table,
        article table td,
        article table th {
            border: 1px solid #ccc;
            padding: 5px 10px;
        }

        /* share this */
        .sharethis-inline-share-buttons {
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .sharethis-inline-share-buttons .st-btn {
            width: 50px !important;
            height: 50px !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-bottom: 10px !important;
            border-radius: 50px !important;
            margin-right: 0 !important
        }

        .sharethis-inline-share-buttons .st-btn img {
            top: 0 !important
        }
    </style>
    
</head>

<body class="antialiased">
    <div class="min-h-screen">
        <!-- Page Header -->
        <x-blog-header title="{{ $settings['app_name'] }}" logo="{{ asset($settings['app_logo']) }}" />
        <!-- Page Content -->
     
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="mt-10 w-full border-t px-5 py-12">
            <div class="container mx-auto">
                <div class="mb-4">
                    <div class="grid justify-between gap-x-10 gap-y-10 sm:grid-cols-3">
                        <div class="flex flex-col items-start gap-3 py-3">
                            <h4 class="text-xl font-semibold">{{ $setting?->title }}</h4>
                            <p class="text-base">
                                {{ $setting?->description }}
                            </p>
                        </div>
                        <div class="grid sm:grid-cols-2 col-span-2">
                            <div class="md:flex md:flex-col grid gap-3 py-3 text-sm font-medium">
                                <h4 class="text-xl font-semibold">روابط  سريعة</h4>
                                @forelse($setting->quick_links ?? [] as $link)
                                    <a href="{{ $link['url'] }}"
                                        class="transition duration-300 will-change-transform hover:translate-x-1 hover:text-black motion-reduce:transition-none motion-reduce:hover:transform-none">
                                        {{ $link['label'] }}
                                    </a>
                                @empty
                                    <p class="font-semibold text-gray-300">لايوجد أي رابط بعد </p>
                                @endforelse
                            </div>
                            <div class="flex flex-col items-start gap-3 text-sm font-medium">
                                <div class="relative overflow-hidden rounded-2xl bg-slate-100 px-6 py-4 text-black">
                                    <div class="mb-3 pb-2 text-xl font-semibold">
                                        الاشتراك في النشرة البريدية
                                    </div>
                                    <div>
                                        <p class="mb-3 block text-slate-500">
                                           اشترك في النشرة البريدية ليصلك جديد الاخبار والمقالات
                                        </p>
                                        <div>
                                            <form method="post" action="{{ route('filamentblog.post.subscribe') }}">
                                                @csrf
                                                <label hidden for="email-address">البريد  الالكتروني</label>
                                                @error('email')
                                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                                @enderror
                                                <div class="w-100 relative">
                                                    <button type="submit"
                                                    class="absolute left-4 top-1/2 -translate-y-1/2 rotate-180">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-primary h-8 w-8"
                                                        viewBox="0 0 256 256">
                                                        <path fill="currentColor"
                                                            d="m220.24 132.24l-72 72a6 6 0 0 1-8.48-8.48L201.51 134H40a6 6 0 0 1 0-12h161.51l-61.75-61.76a6 6 0 0 1 8.48-8.48l72 72a6 6 0 0 1 0 8.48" />
                                                    </svg>
                                                </button>
                                                    <input autocomplete="email"
                                                        class="flex w-full items-center justify-between rounded-xl border bg-white px-6 py-5 font-medium text-black outline-none placeholder:text-black"
                                                        name="email" value="{{ old('email') }}"
                                                        placeholder="ادخل الايميل الخاص بك" type="email">
                                                   
                                                </div>
                                                @if (session('success'))
                                                    <span class="text-green-500 mt-3 block">{{ session('success') }}</span>
                                                @endif
                                            </form>
                                        </div>
                                        <i
                                            class="bi bi-envelope pointer-events-none absolute -right-10 -top-20 text-[9rem] opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
        </footer>
        @include('layouts.footer')
    </div>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("comment-box").submit();
        }
    </script>
</body>

</html>
