<x-filament-panels::page.simple>
    {{-- @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
    @endif --}}

    {{-- {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.before') }} --}}

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.after') }}
    <h4>Don't have an account? <span class="mx-3">{{ $this->registerAction }}</span></h4>
</x-filament-panels::page.simple>
