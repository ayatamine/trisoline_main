@extends('layouts.app')
@section('content')
    <div>
        <section class="py-36 md:h-screen h-auto items-center flex relative relative bg-[url('../../assets/images/bg/import_export.jpg')] bg-center bg-cover" id="home">
            <div class="absolute inset-0 bg-black opacity-80"></div>
            <div class="container relative">
                <div class="grid grid-cols-1 mt-12">
                    <h4 class="text-white lg:text-5xl text-2xl lg:leading-normal leading-normal font-medium mb-5 lg_992:mb-7 position-relative">{{ trans('landing.have_you_any_idea') }} <br>{{ trans('landing.we_can_help_you') }} <span class="typewrite relative text-type-element" data-period="2000" data-type='[{{$text_type_effect}}]'></span></h4>                
                    <div class="text-white opacity-70 mb-0 max-w-2xl lg:text-xl">{!!  $settings["intro_text$locale_extension"] !!}</div>
                
                    <div class="relative mt-10 flex gap-4 items-center">
                        <a href="https://china.trisoline.com" target="_blink" class="btn btn-sm  btn-md  bg-hoverTheme hover:bg-theme border-hoverTheme hover:border-theme text-white rounded-md">{{ trans('landing.china_branch') }}</a>
                        <a href="https://turkey.trisoline.com" target="" class="btn btn-sm btn-md btn bg-theme hover:bg-hoverTheme border-theme hover:border-hoverTheme text-white rounded-md">{{ trans('landing.turkey_branch') }}</a>
                    </div>
                </div>
            </div><!--end container-->
        </section><!--end section-->
        <!-- Hero End -->

        <!-- Start -->
        <section class="relative md:py-24 py-16 px-3  md:px-0 bg-gray-50 dark:bg-slate-800" id="about">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-12 md:grid-cols-2 gap-10 items-center">
                    <div class="lg:col-span-5">
                        <div class="relative">
                            <img src="{{asset('assets/images/trisoline_company.jpg')}}" class="rounded-lg shadow-lg relative" alt="">
                            <!--<div class="absolute bottom-2/4 translate-y-2/4 start-0 end-0 text-center">-->
                            <!--    <button type="button" data-type="iframe" data-target="https://www.facebook.com/watch/?v=942314547618965" class="lightbox h-20 w-20 rounded-full shadow-lg shadow-slate-100 dark:shadow-slate-800 inline-flex items-center justify-center bg-white dark:bg-slate-900 text-hoverTheme">-->
                            <!--        <i class="mdi mdi-play inline-flex items-center justify-center text-2xl"></i>-->
                            <!--    </button>-->
                            <!--</div>-->
                        </div>
                    </div><!--end col-->

                    <div class="lg:col-span-7">
                        <div class="lg:ms-7">
                            <h6 class="text-hoverTheme text-lg font-medium uppercase mb-2">{{ trans('landing.about_us') }}<hr class="w-14 ltr:w-22 h-1 my-2  rounded-md bg-hoverTheme"></h6>
                            <h3 class="mb-4 md:text-2xl text-xl font-medium dark:text-white">{{ trans('landing.company_overview') }}</h3>

                            <div class="text-slate-400 dark:text-slate-300 max-w-2xl mx-auto text-justify">{!! $settings["about_text$locale_extension"] !!}</div>
                        
                            <div class="relative mt-10">
                                <a href="#portfolio" class="btn bg-hoverTheme hover:bg-orange-700 border-hoverTheme hover:border-orange-700 text-white rounded-md">{{ trans('landing.portfolio') }}</a>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end grid-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->

        <!-- Start -->
        <section class="relative md:py-24 py-16 px-3  md:px-0" id="features">
            <div class="container lg mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 md:grid-cols-2 pb-8 items-center">
                    <div>
                        <h6 class="text-hoverTheme text-lg font-medium uppercase mb-2">{{ trans('landing.services_we_offer') }}<hr class="w-38 h-1 my-2  rounded-md bg-hoverTheme"></h6>
                        <h3 class="mb-4 md:text-2xl text-xl font-semibold dark:text-white md:mb-0">{{ trans('landing.best_solutions') }} <br class="hidden "> {{ trans('landing.for_your_business') }} </h3>
                    </div>

                    <div>
                        <p class="text-slate-400 dark:text-slate-300 max-w-xl">{{ trans('landing.launch_your_business') }}</p>
                    </div>
                </div><!--end grid-->
 
                <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-6 group">
                    @foreach ($services as $service)
                   
                    <div class="features shadow-xl shadow-slate-200 dark:shadow-slate-800 transition duration-500 rounded-md mt-8 pb-6 hover:origin-center hover:scale-110 transition duration-500">
                        <div class="w-full h-54 rounded-md text-3xl flex align-middle justify-center items-center shadow-sm ">
                            <img src="{{asset('storage/'.$service['image'])}}" class="w-full h-full rounded-t-md " alt="">
                        </div>
    
                        <div class="content mt-7 p-3 text-center">
                            <a href="javascript:void()" class="text-lg hover:text-hoverTheme dark:text-white dark:hover:text-hoverTheme transition-all duration-500 ease-in-out font-medium">
                               {{$service['title'.$locale_extension]}}
                                <hr class="w-16 h-1 my-3 mx-auto rounded-md bg-hoverTheme">
                            </a>
                            <div class="text-slate-500 mt-5 ltr:text-left rtl:text-right px-3">{!!$service['description'.$locale_extension]!!}</div>
                            
                            <!-- <div class="mt-5">
                                <a href="" class="btn btn-link hover:text-hoverTheme dark:hover:text-hoverTheme after:bg-hoverTheme dark:text-white transition duration-500">Read More <i class="uil uil-arrow-right"></i></a>
                            </div> -->
                        </div>
                    </div>
                    @endforeach
                </div><!--end grid-->
            </div><!--end container-->                 
            
            <div class="container md:mt-24 mt-16">
                <div class="grid grid-cols-1 pb-8 text-center">
                    <h6 class="text-hoverTheme text-lg font-medium uppercase mb-2">{{ trans('landing.operation_guide') }}<hr class="w-36 ltr:w-40 h-1 my-2 mx-auto rounded-md bg-hoverTheme"></h6>
                    <h3 class="mb-4 md:text-2xl text-xl font-medium dark:text-white">{{ trans('landing.digital_system_for_our_business') }}</h3>

                    <p class="text-slate-400 dark:text-slate-300 max-w-xl mx-auto">{{ trans('landing.operation_guide_subtext') }}</p>
                </div><!--end grid-->

                <div class="grid grid-cols-1 mt-8">
                    <div class="timeline relative">
                        @foreach ($steps as $index =>$step)
                            
                        
                        <div class="timeline-item @if(!$loop->first) mt-5 pt-4 @endif">
                            <div class="grid sm:grid-cols-2">
                                <div class=" @if($index % 2 !==0) md:order-1 order-2 @endif">
                                    <div class="duration date-label-left @if($index % 2 !==0)  ltr:float-left rtl:float-right md:ms-7 rotate-180 @else  ltr:float-right rtl:float-left md:me-7  @endif relative">
                                        <img src="{{asset("storage/$step[image]")}}" class="h-64 w-64" alt="">
                                    </div>
                                </div><!--end col-->
                                <div class="mt-4 md:mt-0">
                                    <div class="event @if($index % 2 !==0) event-description-right ltr:float-left rtl:float-right ltr:text-left rtl:text-right md:ms-7 @else   event-description-left ltr:float-left rtl:float-right ltr:text-left rtl:text-right md:ms-7 @endif">
                                        <h5 class="text-lg dark:text-white mb-1 font-medium">{{$step["title$locale_extension"]}}</h5>
                                        <div class="timeline-subtitle mt-3 mb-0 text-slate-400">{!!$step["description$locale_extension"]!!}</div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end grid-->
                        </div><!--end timeline item-->
                        @endforeach
                       
                    </div>
                </div>
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
        @if($settings['show_projects_section'])
        <!-- Start -->
        <section class="relative md:py-24 py-16 px-3  md:px-0 bg-gray-50 dark:bg-slate-800" id="portfolio">
            <div class="container">
                <div class="grid grid-cols-1 pb-8 text-center">
                    <h6 class="text-hoverTheme text-base font-medium uppercase mb-2">{{ trans('landing.portfolio') }}<hr class="w-26 ltr:w-18 h-1 my-2 mx-auto rounded-md bg-hoverTheme"></h6>
                    <h3 class="mb-4 md:text-2xl text-xl font-medium dark:text-white">{{ trans('landing.our_services_and_projects') }}</h3>

                    {{-- <p class="text-slate-400 dark:text-slate-300 max-w-xl mx-auto">Launch your campaign and benefit from our expertise on designing and managing conversion centered Tailwind CSS html page.</p> --}}
                </div><!--end grid-->

                <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2 gap-6 mt-8">
                    @forelse ($projects as $p)
                    <div class="relative rounded-md shadow-sm overflow-hidden group">
                        <img src="{{asset("storage/".$p['thumbnail'])}}" class="group-hover:origin-center group-hover:scale-110 group-hover:rotate-3 transition duration-500" alt="">
                        <div class="absolute inset-0 group-hover:bg-black opacity-50 transition duration-500 z-0"></div>

                        <div class="content">
                            <div class="icon absolute z-10 opacity-0 group-hover:opacity-100 top-4 end-4 transition-all duration-500">
                                <a href="{{asset("storage/".$p['thumbnail'])}}" class="btn bg-hoverTheme hover:bg-orange-700 border-hoverTheme hover:border-orange-700 text-white btn-icon rounded-full lightbox"><i class="uil uil-camera"></i></a>
                            </div>

                            <div class="absolute z-10 opacity-0 group-hover:opacity-100 bottom-4 start-4 transition-all duration-500">
                                <a href="javascript:void()" class="h6 text-md font-medium text-white hover:text-hoverTheme transition duration-500">{{$p["title$locale_extension"]}}</a>
                                <p class="text-slate-100 tag mb-0 text-sm">
                                    @foreach ($p['types'] as $type)
                                        <span>{{$type["title$locale_extension"]}}  ,  </span>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="alert text-info text-lg">No Project added by the admin.</div>
                    @endforelse
                   
                </div><!--end grid-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
        @endif
        <!-- Start -->
        <section class="py-12 w-full table relative bg-[url('../../assets/images/shipping.jpg')] bg-center bg-cover">
            <div class="absolute inset-0 bg-black opacity-80"></div>
            
            <div class="relative md:grid md:grid-cols-3 gap-4 mx-3">
                <div class=" h-full py-10  bg-[#1d8fc3] bg-center text-center p-1 ">
                    <h3 class="mb-6 md:text-3xl text-2xl text-white font-medium">{{ trans('landing.our_vision') }}</h3>

                 <div class="text-white md:text-2xl text-md max-w-xl mx-auto  px-6 lg:px-0  ltr:text-left rtl:text-right">{{  $settings["vision_text$locale_extension"]}}</div>
                </div>
                <div class=" h-full py-10  bg-[#fe7b07] bg-center text-center p-1 ">
                    <h3 class="mb-6 md:text-3xl text-2xl text-white font-medium">{{ trans('landing.our_goals') }}</h3>

                    <div class="text-white md:text-2xl text-md max-w-xl mx-auto  px-6 lg:px-0  ltr:text-left rtl:text-right">{{  $settings["goals_text$locale_extension"]}}</div>
                
                </div>
                <div class=" h-full py-10  bg-[#695f5f] bg-center text-center p-1 ">
                    <h3 class="mb-6 md:text-3xl text-2xl text-white font-medium">{{ trans('landing.our_values') }}</h3>

                    <div class="text-white md:text-2xl text-md max-w-xl mx-auto  px-6 lg:px-0  ltr:text-left rtl:text-right">{{ $settings["values_text$locale_extension"]}}</div>
                
                </div>
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->

        @if($settings['show_testimonials_section'])
        <!-- start -->
        <section class="relative md:py-24 py-16 px-3  md:px-0 bg-gray-50 dark:bg-slate-800" id="testi">
            <div class="container">
                <div class="grid grid-cols-1 pb-8 text-center">
                    <h6 class="text-hoverTheme text-lg font-medium uppercase mb-2">{{ trans('landing.clients_section') }}<hr class="w-26   ltr:w-37 h-1 my-2 mx-auto rounded-md bg-hoverTheme"></h6>
                    <h3 class="mb-4 md:text-2xl text-xl font-medium dark:text-white">{{ trans('landing.some_clients_thoughts') }}</h3>

                    <!-- <p class="text-slate-400 dark:text-slate-300 max-w-xl mx-auto">Launch your campaign and benefit from our expertise on designing and managing conversion centered Tailwind CSS html page.</p> -->
                </div><!--end grid-->
                
                <div class="grid grid-cols-1 mt-8 relative">
                    <div class="tiny-two-item">
                        @forelse ($testimonials as $te)
                        <div class="tiny-slide">
                            <div class="lg:flex p-6 lg:p-0 relative rounded-md shadow shadow-slate-200 dark:shadow-slate-700 bg-white dark:bg-slate-900 overflow-hidden m-2">
                                <img class="w-24 h-24 lg:w-48 lg:h-auto lg:rounded-none rounded-full mx-auto" src="{{asset("storage/$te->client_thumbnail")}}" alt="" width="384" height="512">
                                <div class="pt-6 lg:p-6 text-center lg:text-left space-y-4">
                                    <p class="text-base text-slate-500 dark:text-slate-200"> "{{$te->content}}"</p>
                                    
                                    <div>
                                        <span class="text-hoverTheme block mb-1">{{$te->client_name}}</span>
                                        <span class="text-slate-400 text-sm dark:text-white/60 block">{{$te->client_country}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div cla 
                        @empty
                            <div class="alert text-info text-lg">No Review Yet.</div>
                        @endforelse
                    </div>
                </div><!--end grid-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
        @endif

        @if($settings["show_blog_section"])
        <!-- Start -->
        <section class="relative md:py-24 py-16 px-3  md:px-0" id="blog">
            <div class="container">
                <div class="grid grid-cols-1 pb-8 text-center">
                    <h6 class="text-hoverTheme text-lg font-medium uppercase mb-2">{{ trans('landing.blog') }}<hr class="w-14 ltr:w-12 h-1 my-2 mx-auto rounded-md bg-hoverTheme"></h6>
                    <h3 class="mb-4 md:text-2xl text-xl font-medium dark:text-white">{{ trans('landing.latest_news') }}</h3>

                    <!-- <p class="text-slate-400 dark:text-slate-300 max-w-xl mx-auto">Launch your campaign and benefit from our expertise on designing and managing conversion centered Tailwind CSS html page.</p> -->
                </div><!--end grid-->

                <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-6 mt-8">
                    @foreach ($blogs as $blog)
                        
                    <div class="blog relative rounded-md shadow shadow-slate-200 dark:shadow-slate-800 overflow-hidden">
                        <img src="{{asset("storage/$blog->cover_photo_path")}}"  alt="{{$blog->photo_alt_text}}">
    
                        <div class="content p-6 text-right">
                            <a href="javascript:void()" class="text-md md:text-lg  dark:text-white  font-medium">{{$blog->title}}</a>
                            {{-- <pre class="text-slate-400 mt-3">{!!Illuminate\Support\Str::limit($blog->body,100)!!}</pre><br> --}}
                            
                            <div class="mt-5">
                                <a href="{{route('filamentblog.post.show',$blog->slug)}}" class="btn text-theme btn-link hover:text-hoverTheme dark:hover:text-hoverTheme after:bg-hoverTheme dark:text-white transition duration-500">قراءة المزيد <i class="uil uil-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div><!--end grid-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
        @endif
        <!-- Start -->
        <section class="relative md:py-24 py-16 px-3  md:px-0 bg-gray-50 dark:bg-slate-800" id="contact">
            <div class="container">
                <div class="grid grid-cols-1 pb-8 text-center">
                    <!-- <h6 class="text-hoverTheme text-base font-medium uppercase mb-2">تواصل معنا</h6> -->
                    <h3 class="mb-4 md:text-2xl text-xl font-medium dark:text-white text-hoverTheme ">{{ trans('landing.contact_us') }}<hr class="w-20 ltr:w-32 h-1 my-2 mx-auto rounded-md bg-hoverTheme"></h3>

                    <p class="text-slate-400 dark:text-slate-300 max-w-xl mx-auto">{{ trans('landing.you_can_contact_us_and_reply_soon') }}</p>
                </div><!--end grid-->

                <div class="grid grid-cols-1 lg:grid-cols-12 md:grid-cols-2 mt-8 items-center gap-6">
                    <div class="lg:col-span-8">
                        <div class="p-6 rounded-md shadow bg-white dark:bg-slate-900">
                            <form method="post" name="myForm" id="myForm" action="{{route('send_contact')}}" onsubmit="return validateForm()">
                                @csrf
                                <p class="mb-0" id="error-msg"></p>
                                <div id="simple-msg"></div>
                                <div class="grid lg:grid-cols-12 lg:gap-6">
                                    <div class="lg:col-span-6 mb-5">
                                        <input name="name" id="name" type="text" class="form-input" placeholder="{{ trans('landing.full_name') }} :">
                                    </div>
    
                                    <div class="lg:col-span-6 mb-5">
                                        <input name="email" id="email" type="email" class="form-input" placeholder="{{ trans('landing.email') }} :">
                                    </div><!--end col-->
                                </div>

                                <div class="grid grid-cols-1">
                                    <div class="mb-5">
                                        <input name="subject" id="subject" class="form-input" placeholder="{{ trans('landing.subject') }} :">
                                    </div>

                                    <div class="mb-5">
                                        <textarea name="message" id="comments" class="form-input textarea h-28" placeholder="{{ trans('landing.message_body') }} :"></textarea>
                                    </div>
                                </div>
                                @if (session('error'))
                                <p class=" text-xs mt-1" style="color: red;margin-bottom:7px">{{ session('error')  }}</p>
                                @enderror
                                @if (session('success'))
                                    <p class="mt-1" style="color: green;margin-bottom:7px">{{ session('success') }}</p>
                                @endif
                                <button type="submit" id="submit" name="send" class="btn  btn-sm bg-hoverTheme hover:bg-orange-700 border-hoverTheme hover:border-orange-700 text-white rounded-md h-11 justify-center flex items-center">{{ trans('landing.send_message') }}</button>
                            </form>
                        </div>
                    </div>

                    <div class="lg:col-span-4">
                        <div class="lg:ms-8">
                            <div class="flex">
                                <div class="icons text-center mx-auto">
                                    <i class="uil uil-phone block rounded text-2xl dark:text-white mb-0"></i>
                                </div>
    
                                <div class="flex-1 ms-6">
                                    <h5 class="text-md md:text-lg dark:text-white mb-2 font-medium">{{ trans('landing.phone_number') }}</h5>
                                    <a href="tel:+152534-468-854" class="text-sm md:text-md text-slate-400">{{$settings['phone_number']}}</a>
                                </div>
                            </div>
                            <div class="flex mt-4">
                                <div class="icons text-center mx-auto">
                                    <i class="uil uil-phone block rounded text-2xl dark:text-white mb-0"></i>
                                </div>
    
                                <div class="flex-1 ms-6">
                                    <h5 class="text-md md:text-lg dark:text-white mb-2 font-medium">{{ trans('landing.turkey_phone_number') }}</h5>
                                    <a href="tel:+152534-468-854" class="text-sm md:text-md text-slate-400">{{$settings['turkey_phone_number']}}</a>
                                </div>
                            </div>
    
                            <div class="flex mt-4">
                                <div class="icons text-center mx-auto">
                                    <i class="uil uil-envelope block rounded text-2xl dark:text-white mb-0"></i>
                                </div>
    
                                <div class="flex-1 ms-6">
                                    <h5 class="text-md md:text-lg dark:text-white mb-2 font-medium">{{ trans('landing.email') }}</h5>
                                    <a href="mailto:contact@example.com" class="text-sm md:text-md text-slate-400">{{$settings['contact_email']}}</a>
                                </div>
                            </div>
    
                            <div class="flex mt-4">
                                <div class="icons text-center mx-auto">
                                    <i class="uil uil-map-marker block rounded text-2xl dark:text-white mb-0"></i>
                                </div>
    
                                <div class="flex-1 ms-6">
                                    <h5 class="text-md md:text-lg dark:text-white mb-2 font-medium">{{ trans('landing.address') }}</h5>
                                    <p class="text-sm md:text-md text-slate-400 mb-2">{{$settings['address']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end grid-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
    </div>
@endsection