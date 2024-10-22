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
                  <div class="h-full w-1 @if($getState() != "processed" || $getState() != "pending") bg-green-500 text-white @else bg-gray-300 @endif pointer-events-none"></div>
                </div>
                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full @if($getState() != "processed"  || $getState() != "pending") bg-green-500 text-white @else bg-gray-300 @endif shadow text-center">
                  <i class="fas fa-check-circle text-white"></i>
                </div>
              </div>
              <div class="@if($getState() != "processed"  ||   $getState() != "pending") bg-green-500 text-white @else bg-gray-300 @endif  col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full ">
                <h3 class="font-semibold text-lg mb-1">{{trans('dash.processing')}}</h3>
                <p class="leading-tight text-justify w-full">
                   @if($getRecord()->processing_at) {{\Carbon\Carbon::createFromDate($getRecord()->processing_at)->isoFormat('D MMM YYYY, h:mm A')}} @endif
                </p>
              </div>
            </div>
    
            <div class="flex md:contents">
              <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                <div class="h-full w-6 flex items-center justify-center">
                  <div class="h-full w-1 @if($getState() == "processed") bg-green-500 text-white @else bg-gray-300 @endif pointer-events-none"></div>
                </div>
                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full @if($getState() == "processed") bg-green-500 text-white @else bg-gray-300 @endif shadow text-center">
                  <i class="fas fa-check-circle text-white"></i>
                </div>
              </div>
              <div class="@if($getState() == "processed") bg-green-500 text-white @else bg-gray-300 @endif  col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full  ">
                <h3 class="font-semibold text-lg mb-1">{{trans('dash.processed')}} </h3>
                <p class="leading-tight text-justify">
                    @if($getRecord()->processed_at) {{\Carbon\Carbon::createFromDate($getRecord()->processed_at)->isoFormat('D MMM YYYY, h:mm A')}} @endif
                </p>
              </div>
            </div>
    
            <div class="flex md:contents">
              <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                <div class="h-full w-6 flex items-center justify-center">
                  <div class="h-full w-1 @if($getState() == "rejected") bg-red-500 text-white @else bg-gray-300   @endif pointer-events-none"></div>
                </div>
                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full @if($getState() == "rejected") bg-red-500 text-white @else bg-gray-300   @endif shadow text-center">
                  <i class="fas fa-times-circle text-white"></i>
                </div>
              </div>
              <div class="@if($getState() == "rejected") bg-red-500 text-white @else bg-gray-300   @endif col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full">
                <h3 class="font-semibold text-lg mb-1 text-gray-50">{{trans('dash.rejected')}}</h3>
                <p class="leading-tight text-justify">
                    @if($getRecord()->rejected_at) {{\Carbon\Carbon::createFromDate($getRecord()->rejected_at)->isoFormat('D MMM YYYY, h:mm A')}} @endif
                    {{$getRecord()->rejection_note}}
                </p>
              </div>
            </div>
    
          </div>
        </div>
      </div>
</x-dynamic-component>
