<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
   
    <div id="quota-discussion">
        @filepondScripts

        @if(!$getState()) 
        <div class="bg-blue-300 text-white w-full p-2 rounded">
            {{trans('dash.order_discussion_not_yet_started')}}
        </div>
        @else
        @if($getRecord()?->discussion?->is_open)
        <div style="float: right; margin:1rem 0">
            {{ $getAction('closeDiscussion') }}
        </div>
        @else
        <div class="bg-blue-300 text-white w-full p-2 rounded mb-2">
            {{trans('dash.order_discussion_is_closed_now')}}
        </div>
        <div style="float: right; margin:1rem 0">
          {{ $getAction('reopenDiscussion') }}
        </div>
        @endif
        <!-- Component Start -->
        <div class="flex flex-col flex-grow w-full min-h-43 bg-white shadow-xl rounded-lg overflow-hidden border">
            
            <div class="flex flex-col flex-grow h-0 p-4 overflow-auto">
               
                @foreach ($getState()?->messages as $message)
                    @if($message->sender_id ==Auth::id())
                        <div class="flex w-full mt-2 space-x-3 max-w-7xl">
                            {{-- <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300"></div> --}}
                            <div>
                                <h3 class="font-semibold mb-2">{{trans('dash.you')}}</h3>
                                <div class="bg-gray-300 p-3 rounded-r-lg rounded-r-xl rounded-b-xl">
                                    <p class="text-sm">{{$message->content}}</p>
                                </div>
                                <span class="text-xs text-gray-500 leading-none">{{\Carbon\Carbon::createFromDate($message->created_at)->diffForHumans()}}</span>
                                {{-- attachments --}}
                                <div>
                                    @if($message->attachments)
                                        @foreach ($message->attachments as $attachment)
                                            | <a href="{{url("storage/$attachment")}}" target="_blink" style="color: rgb(33, 86, 184);" class="text-sm underline">{{Str::limit($attachment,30)}}</a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else 
                        <div class="flex w-full mt-2 space-x-3 max-w-7xl ml-auto justify-end">
                            <div>
                                <h3 class="font-semibold mb-2 text-right">@if(!auth()->user()->is_admin) {{trans('dash.moderator')}} @else {{$getRecord()?->client?->user?->name}} @endif</h3>
                                <div class="bg-blue-300 text-white p-3 rounded-l-xl rounded-b-xl">
                                    <p class="text-sm">{{$message->content}}</p>
                                </div>
                                <span class="text-xs text-gray-500 leading-none">{{\Carbon\Carbon::createFromDate($message->created_at)->diffForHumans()}}</span>
                                <div>
                                    @if($message->attachments)
                                        @foreach ($message->attachments as $attachment)
                                            | <a href="{{url("storage/$attachment")}}" target="_blink" style="color: rgb(33, 86, 184);" class="text-sm underline">{{Str::limit($attachment,30)}}</a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300"></div> --}}
                        </div>
                    @endif
                @endforeach
                
               
                
            </div>
            @if($getRecord()?->discussion?->is_open)
            <div class="bg-gray-300 p-4">
                <form action="">
                    <div class="flex items-start justify-between gap-3">
                        <div class=" w-50">
                            <textarea wire:model="content" class="flex items-center  rounded px-3 text-sm w-full" type="text" rows="5" required></textarea>
                            <div>
                                @error('content') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex items-start justify-center gap-2 w-50">
                            <div class="w-80">
                                {{-- <label for="attachment" class="flex items-center gap-2 justify-between bg-gray-300 rounded add-attachment-btn">
                                    <svg class="h-5 w-5" id="Layer_1" enable-background="new 0 0 56 64" height="64" viewBox="0 0 56 64" width="56" xmlns="http://www.w3.org/2000/svg"><g id="File_78_"><g><path d="m52 0h-48c-2.209 0-4 1.79-4 4v56c0 2.209 1.791 4 4 4h34l18-18v-42c0-2.21-1.791-4-4-4z" fill="#ed7261"/></g></g><g id="Corner_41_"><g><path d="m42 46c-2.209 0-4 1.791-4 4v14l18-18z" fill="#ba594c"/></g></g><g id="Attachment_1_"><g><path clip-rule="evenodd" d="m39.661 14.335c-3.118-3.119-8.179-3.116-11.301.006-.004.004-.007.008-.011.012h-.001l-12.006 11.997.006.006c-.002.001-.004.002-.005.004-3.122 3.123-3.126 8.184-.007 11.302 2.584 2.584 6.498 3.019 9.541 1.318-1.674-.083-3.322-.755-4.6-2.033-.43-.43-.783-.904-1.078-1.404-.366-.186-.717-.414-1.023-.721-1.558-1.557-1.558-4.081-.003-5.642l-.006-.005 2.028-2.029c.029-.031.054-.065.084-.096.022-.022.049-.037.07-.059l2.7-2.701 2.24-2.241 4.877-4.878.019.019c.056-.063.098-.134.158-.194 1.516-1.516 4.006-1.482 5.563.073 1.557 1.558 1.589 4.047.073 5.563-.061.061-.131.103-.194.158l.034.034-9.883 9.883c-.39.39-1.022.39-1.413 0-.39-.39-.39-1.022 0-1.412l7.097-7.083c.747-.778.734-2.019-.04-2.795-.78-.779-2.036-.789-2.813-.024l-.002-.002-7.067 7.078.021.02c-.084.073-.177.128-.256.208-1.895 1.894-1.854 5.007.092 6.953 1.945 1.944 5.059 1.985 6.953.093.079-.079.139-.17.211-.253l.043.043 9.889-9.888-.002-.002c.002-.002.004-.003.006-.005 3.122-3.124 3.125-8.184.006-11.303z" fill="#fff" fill-rule="evenodd"/></g></g><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/></svg>
                                    {{trans('dash.add_attachment')}}
                                </label> --}}
                                {{-- <input  id="attachment" wire:model="attachments" class="hidden flex items-center h-10 w-full rounded px-3 text-sm" type="file" multiple > --}}
                                <x-filepond::upload wire:model="attachments" multiple class="w-60" axFileSize="4mb"/>

                            </div>
                            <x-filament::button  wire:click.prevent="sendMessage" type="submit" class=" w-1/2 w-20"  size="lg" >
                                {{trans('dash.send')}}
                            </x-filament::button>
                        </div>
                    </div>
                </form>

            </div>
            @else

            @endif
        </div>
        @endif
        <!-- Component End  -->
    </div>
    <x-filament-actions::modals />
</x-dynamic-component>
