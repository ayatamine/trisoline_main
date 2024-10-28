<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        @if($getState())
        @foreach ($getState() as $container)
            <div class="my-2">
                    <strong>{{trans("dash.".$container['type']."")}} => </strong> <span class="bg-green-500 p-1 rounded text-white ">{{$container['count']}}</span>
            </div>
        @endforeach
       @endif
    </div>
</x-dynamic-component>
