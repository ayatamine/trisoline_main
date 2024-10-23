<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    {{-- <div>
        {{ $getState() }}
    </div> --}}
    <div class="p-4 mt-4">
        <div class="container">
          <div class="flex flex-col md:grid grid-cols-12 text-gray-50">
            
            <div class="flex md:contents">
                <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                  <div class="h-full w-6 flex items-center justify-center">
                    <div class="h-full w-1 @if($getState() != "pending") bg-green-500 @else bg-blue-300 @endif pointer-events-none text-white"></div>
                  </div>
                  <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full  @if($getState() != "pending") bg-green-500 @else bg-blue-300 @endif shadow text-center text-white ">
                    <i class="fas fa-exclamation-circle text-gray-400"></i>
                  </div>
                </div>
                <div class=" @if($getState() != "pending") bg-green-500 @else bg-blue-300 @endif col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full text-white">
                  <h3 class="font-semibold text-lg mb-1 ">{{trans("dash.pending")}}</h3>
                  <p class="leading-tight text-justify">
                  {{\Carbon\Carbon::createFromDate($getRecord()->created_at)->isoFormat('D MMM YYYY, h:mm A')}}
                  </p>
                </div>
            </div>
          
            <div class="flex md:contents">
              <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                <div class="h-full w-6 flex items-center justify-center">
                  <div class="h-full w-1 @if(in_array($getState(),['approved','inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif pointer-events-none"></div>
                </div>
                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full  @if(in_array($getState(),['approved','inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif shadow text-center">
                  <i class="fas fa-check-circle text-white"></i>
                </div>
              </div>
              <div class=" @if(in_array($getState(),['approved','inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif  col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full ">
                <h3 class="font-semibold text-lg mb-1">{{trans('dash.approved')}}</h3>
                <p class="leading-tight text-justify w-full">
                   @if($getRecord()->approved_at) {{\Carbon\Carbon::createFromDate($getRecord()->approved_at)->isoFormat('D MMM YYYY, h:mm A')}} @endif
                </p>
              </div>
            </div>
            <div class="flex md:contents">
                <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                  <div class="h-full w-6 flex items-center justify-center">
                    <div class="h-full w-1  @if(in_array($getState(),['inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif pointer-events-none"></div>
                  </div>
                  <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full  @if(in_array($getState(),['inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif shadow text-center">
                    <i class="fas fa-check-circle text-white"></i>
                  </div>
                </div>
                <div class=" @if(in_array($getState(),['inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif  col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full  ">
                  <h3 class="font-semibold text-lg mb-1">{{trans('dash.inspected')}} </h3>
                  <p class="leading-tight text-justify">
                      @if($getRecord()->inspected_at) {{\Carbon\Carbon::createFromDate($getRecord()->inspected_at)->isoFormat('D MMM YYYY, h:mm A')}} @endif
                  </p>
                </div>
              </div>

            <div class="flex md:contents">
              <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                <div class="h-full w-6 flex items-center justify-center">
                  <div class="h-full w-1  @if(in_array($getState(),['inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif pointer-events-none"></div>
                </div>
                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full  @if(in_array($getState(),['inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif shadow text-center">
                  <i class="fas fa-check-circle text-white"></i>
                </div>
              </div>
              <div class=" @if(in_array($getState(),['inspected','completed','refunded']))  bg-green-500 text-white @else bg-gray-300 @endif  col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full  ">
                <h3 class="font-semibold text-lg mb-1">{{trans('dash.completed')}} </h3>
                <p class="leading-tight text-justify">
                    @if($getRecord()->completed_at) {{\Carbon\Carbon::createFromDate($getRecord()->completed_at)->isoFormat('D MMM YYYY, h:mm A')}} @endif
                </p>
              </div>
            </div>
    
            <div class="flex md:contents">
              <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                <div class="h-full w-6 flex items-center justify-center">
                  <div class="h-full w-1 @if($getState() == "refunded") bg-red-500 text-white @else bg-gray-300   @endif pointer-events-none"></div>
                </div>
                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full @if($getState() == "refunded") bg-red-500 text-white @else bg-gray-300   @endif shadow text-center">
                  <i class="fas fa-times-circle text-white"></i>
                </div>
              </div>
              <div class="@if($getState() == "refunded") bg-red-500 text-white @else bg-gray-300   @endif col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full">
                <h3 class="font-semibold text-lg mb-1 text-gray-50">{{trans('dash.refunded')}}</h3>
                <p class="leading-tight text-justify">
                    @if($getRecord()->refunded_at) {{\Carbon\Carbon::createFromDate($getRecord()->refunded_at)->isoFormat('D MMM YYYY, h:mm A')}} @endif
                    {{$getRecord()->rejection_note}}
                </p>
              </div>
            </div>
    
          </div>
        </div>
      </div>
</x-dynamic-component>
