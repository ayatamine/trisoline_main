<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('accept_contract') }">
        <!-- Interact with the `state` property in Alpine.js -->
        <x-filament::input.checkbox
        x-model="accept_contract"
         />
    <span class="text-sm md:font-semibold">{{trans('dash.accept_contract_text')}}</span> <a target="_blink" href="{{route('quotation_terms')}}" class="text-info underline" style="color: blue">{{trans('dash.accept_contract_title')}}</a>
    </div>
</x-dynamic-component>

{{-- <div x-data="{ errors: ['accept_contract'] }">

    <x-filament::input.checkbox
        x-model="accept_contract"
        alpine-valid="! errors.includes('accept_contract')" 
    />
    <span class="text-sm md:font-semibold">{{trans('dash.accept_contract_text')}}</span> <a target="_blink" href="{{route('quotation_terms')}}" class="text-info underline" style="color: blue">{{trans('dash.accept_contract_title')}}</a>

</div> --}}