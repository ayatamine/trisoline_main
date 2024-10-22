<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
       
    </div>
    <div class="mt-6 sm:mt-8 w-full lg:w-2/3 border rounded-lg">
        <div class="relative overflow-x-auto border-b border-gray-200 dark:border-gray-800">
          <table class="w-full text-left font-medium text-gray-900 dark:text-white md:table-fixed">
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              @php
                  $total = 0;
              @endphp
             @if($getRecord()->products()->get())
              @foreach ($getRecord()->products()->get() as $product)
                  
              @php
                  $total+=$product->expected_price;
              @endphp
              <tr>
                <td class="whitespace-nowrap p-6 md:w-[384px]">
                  <div class="flex items-center gap-4">
                    <a href="#" class="flex items-center aspect-square w-8 h-8 shrink-0 drop-shadow-lg  shadow-lg">
                      <img class="h-auto w-full max-h-full" 
                       @if($product->thumbnail  && $product->thumbnail!='') src="{{url("storage/$product->thumbnail")}}" @else src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" @endif
                       alt="{{$product->name}}" />
                    </a>
                    <a href="#" class="hover:underline text-sm">{{$product->name}}</a>
                  </div>
                </td>

                <td class="p-4 text-base font-normal text-gray-900 dark:text-white">x{{$product->quantity}}</td>

                <td class="p-4 text-right text-base font-bold text-gray-900 dark:text-white">{{$getRecord()->currency}} {{$product->expected_price}}</td>
              </tr>
              @endforeach
              @endif

            </tbody>
          </table>
        </div>

        <div class="mt-4 space-y-6 p-6 ">
          <h4 class="text-xl font-semibold text-gray-900 dark:text-white">{{trans('dash.Expected_Delivery_Date')}}</h4>

          <div class="space-y-4">
            <div class="space-y-2">
              <dl class="flex items-center justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">{{trans('dash.Original_price')}}</dt>
                <dd class="text-base font-medium text-gray-900 dark:text-white">{{$getRecord()->currency}} {{$total}}</dd>
              </dl>
              {{-- <dl class="flex items-center justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">{{trans('dash.Handling_Service')}}</dt>
                <dd class="text-base font-medium text-gray-900 dark:text-white">{{$getRecord()->currency}} 0</dd>
              </dl> --}}

            </div>

            
          </div>

    
 
        </div>
      </div>
</x-dynamic-component>
