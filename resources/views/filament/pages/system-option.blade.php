 <x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
        <div>
            <x-filament-panels::form.actions 
            :actions="$this->getFormActions()"
        /> 
        </div>
        <div class="flex">

            <!-- Previous Button -->
            @if($this->prev !=null)
            <a href="{{route('filament.admin.pages.system-option',['lang'=>$lang,'page'=>$prev])}}" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
              Previous
            </a>
            @endif

            @if($this->next  !=null)
            <!-- Next Button -->
            <a href="{{route('filament.admin.pages.system-option',['lang'=>$lang,'page'=>$next])}}" class="flex items-center justify-center px-3 h-8 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
              Next
            </a>
            @endif
          </div>
          
    </x-filament-panels::form>
</x-filament-panels::page>
