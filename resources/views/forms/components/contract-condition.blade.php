{{-- <x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
    </div>
</x-dynamic-component> --}}

<div x-data="{ errors: ['accept_contact'] }">

    <x-filament::input.checkbox
        x-model="accept_contact"
        alpine-valid="! errors.includes('accept_contact')" 
    />
    <span class="text-sm md:font-semibold">{{trans('dash.accept_contract_text')}}</span> <a target="_blink" href="{{route('quotation_terms')}}" class="text-info underline" style="color: blue">{{trans('dash.accept_contract_title')}}</a>

</div>