<div class="py-12">
    <style>
        .checked\:ring-0:checked
        {
            background-color: #d97706  !important
        }

        @media(max-width:500px)
        {
            .fi-btn
            {
                padding: 0.3rem
            }
            .fi-btn-label{
                font-size:0.7rem;
            }
        }
        .dark .fi-fo-repeater-item {
            background-color: #111827 !important;
        }
        .dark .fi-btn{
            background-color: #f59e0b !important
        }
        @media (min-width: 992px) {
            .navbar.is-sticky .navbar-nav.nav-light .nav-link {
                --tw-text-opacity: 1;
                color: white !important
            }
        }
    </style>
    @guest
    @if(!$is_success)
    <form>
        {{ $this->form }}
        
        <div class="flex items-center justify-between gap-4">
           
              <x-filament::button  wire:click.prevent="create" type="submit" class="mt-3  w-1/2"  size="lg" tooltip="{{trans('dash.submit_only_tooltip')}}">
                {{trans('dash.submit_quota')}}
              </x-filament::button>
              <x-filament::button  wire:click.prevent="createWithAccount" type="submit" class="mt-3  w-1/2"  size="lg" color="info" tooltip="{{trans('dash.submit_and_create_account_tooltip')}}">
                {{trans('dash.submit_create_account')}}
              </x-filament::button>
           
        </div>
    </form>
    @else 
        <div class="mt-20">
            <div class="bg-success bg-green-500 text-white p-4 rounded-2xl">
                {{trans('dash.quota_created_successfully')}}
            </div>
            <div class="flex items-center justify-between gap-4 pt-3">
                <a wire:click.prevent="$set('is_success',false)" href="{{route('create_quota')}}"  class="btn bg-blue-500 rounded-lg text-white mt-3  w-1/2"  >
                {{trans('dash.go_back')}}
                </a>
                <a  href="{{route('filament.client.auth.login')}}" type="submit" class="btn bg-gray-500 rounded-lg text-white mt-3  w-1/2"  >
                {{trans('dash.login')}}
                </a>
            </div>
        </div>
    @endif
    @else 
    <div class="p-12 rounded shadow-md dark:bg-gray-900 text-dark dark:text-white  text-center">
        <div class="text-blue-500 font-semibold p-4 rounded">
            {{trans('dash.this_form_is_for_guest')}}
        </div>
        <a  href="{{route("filament.client.resources.quotas.create")}}"  class="btn bg-gray-500 rounded-lg text-white mt-3  w-1/2"  >
            {{trans('dash.go_to_dashboard')}}
        </a>
    </div>
    @endguest
    @livewire('notifications')
</div>