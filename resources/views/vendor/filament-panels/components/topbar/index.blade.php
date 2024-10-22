@props([
    'navigation',
])

<div
    {{
        $attributes->class([
            'fi-topbar sticky top-0 z-20 overflow-x-clip',
            'fi-topbar-with-navigation' => filament()->hasTopNavigation(),
        ])
    }}
>
    <nav
        class="flex h-16 items-center gap-x-4 bg-white px-4 shadow-sm ring-1 ring-gray-950/5 md:px-6 lg:px-8 dark:bg-gray-900 dark:ring-white/10"
    >
        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::topbar.start') }}

        @if (filament()->hasNavigation())
            <x-filament::icon-button
                color="gray"
                icon="heroicon-o-bars-3"
                icon-alias="panels::topbar.open-sidebar-button"
                icon-size="lg"
                :label="__('filament-panels::layout.actions.sidebar.expand.label')"
                x-cloak
                x-data="{}"
                x-on:click="$store.sidebar.open()"
                x-show="! $store.sidebar.isOpen"
                @class([
                    'fi-topbar-open-sidebar-btn',
                    'lg:hidden' => (! filament()->isSidebarFullyCollapsibleOnDesktop()) || filament()->isSidebarCollapsibleOnDesktop(),
                ])
            />

            <x-filament::icon-button
                color="gray"
                icon="heroicon-o-x-mark"
                icon-alias="panels::topbar.close-sidebar-button"
                icon-size="lg"
                :label="__('filament-panels::layout.actions.sidebar.collapse.label')"
                x-cloak
                x-data="{}"
                x-on:click="$store.sidebar.close()"
                x-show="$store.sidebar.isOpen"
                class="fi-topbar-close-sidebar-btn lg:hidden"
            />
        @endif

        @if (filament()->hasTopNavigation() || (! filament()->hasNavigation()))
            <div class="me-6 hidden lg:flex">
                @if ($homeUrl = filament()->getHomeUrl())
                    <a {{ \Filament\Support\generate_href_html($homeUrl) }}>
                        <x-filament-panels::logo />
                    </a>
                @else
                    <x-filament-panels::logo />
                @endif
            </div>

            @if (filament()->hasTenancy() && filament()->hasTenantMenu())
                <x-filament-panels::tenant-menu class="hidden lg:block" />
            @endif

            @if (filament()->hasNavigation())
                <ul class="me-4 hidden items-center gap-x-4 lg:flex">
                    @foreach ($navigation as $group)
                        @if ($groupLabel = $group->getLabel())
                            <x-filament::dropdown
                                placement="bottom-start"
                                teleport
                            >
                                <x-slot name="trigger">
                                    <x-filament-panels::topbar.item
                                        :active="$group->isActive()"
                                        :icon="$group->getIcon()"
                                    >
                                        {{ $groupLabel }}
                                    </x-filament-panels::topbar.item>
                                </x-slot>

                                <x-filament::dropdown.list>
                                    @foreach ($group->getItems() as $item)
                                        @php
                                            $icon = $item->getIcon();
                                        @endphp

                                        <x-filament::dropdown.list.item
                                            :badge="$item->getBadge()"
                                            :badge-color="$item->getBadgeColor()"
                                            :href="$item->getUrl()"
                                            :icon="$item->isActive() ? ($item->getActiveIcon() ?? $icon) : $icon"
                                            tag="a"
                                            :target="$item->shouldOpenUrlInNewTab() ? '_blank' : null"
                                        >
                                            {{ $item->getLabel() }}
                                        </x-filament::dropdown.list.item>
                                    @endforeach
                                </x-filament::dropdown.list>
                            </x-filament::dropdown>
                        @else
                            @foreach ($group->getItems() as $item)
                                <x-filament-panels::topbar.item
                                    :active="$item->isActive()"
                                    :active-icon="$item->getActiveIcon()"
                                    :badge="$item->getBadge()"
                                    :badge-color="$item->getBadgeColor()"
                                    :icon="$item->getIcon()"
                                    :should-open-url-in-new-tab="$item->shouldOpenUrlInNewTab()"
                                    :url="$item->getUrl()"
                                >
                                    {{ $item->getLabel() }}
                                </x-filament-panels::topbar.item>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            @endif
        @endif

        <div
            x-persist="topbar.end"
            class="ms-auto flex items-center gap-x-4"
        >
            {{ \Filament\Support\Facades\FilamentView::renderHook('panels::global-search.before') }}

            @if (filament()->isGlobalSearchEnabled())
                @livewire(Filament\Livewire\GlobalSearch::class, ['lazy' => true])
            @endif

            {{ \Filament\Support\Facades\FilamentView::renderHook('panels::global-search.after') }}
            <a class="mx-1" target="_blank" href="{{route('home')}}"> <svg class="h-8 w-8" fill="#3050b0" viewBox="0 0 512 512" id="_x30_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#3050b0"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M157.114,188.969h28.438c3.269-13.719,7.51-26.333,12.545-37.485c-9.62,5.348-18.555,12.064-26.552,20.061 C166.14,176.95,161.323,182.786,157.114,188.969z"></path> <path d="M157.114,323.031c4.21,6.183,9.026,12.019,14.431,17.424c7.997,7.997,16.932,14.713,26.552,20.061 c-5.036-11.152-9.276-23.766-12.545-37.485H157.114z"></path> <path d="M354.886,188.969c-4.21-6.183-9.026-12.019-14.431-17.424c-7.997-7.997-16.932-14.713-26.552-20.061 c5.036,11.152,9.276,23.766,12.545,37.485H354.886z"></path> <path d="M278.452,162.043c-9.626-19.252-19.283-25.48-22.452-25.48s-12.826,6.228-22.452,25.48 c-3.987,7.975-7.409,17.059-10.208,26.926h65.32C285.86,179.102,282.439,170.017,278.452,162.043z"></path> <path d="M233.548,349.957c9.626,19.252,19.283,25.48,22.452,25.48s12.826-6.228,22.452-25.48 c3.987-7.975,7.409-17.059,10.208-26.926h-65.32C226.14,332.898,229.561,341.983,233.548,349.957z"></path> <path d="M178,256c0-10.428,0.516-20.614,1.492-30.469h-39.021c-2.573,9.825-3.909,20.043-3.909,30.469s1.335,20.644,3.909,30.469 h39.021C178.516,276.614,178,266.428,178,256z"></path> <path d="M334,256c0,10.428-0.516,20.614-1.492,30.469h39.021c2.573-9.825,3.909-20.043,3.909-30.469s-1.335-20.644-3.909-30.469 h-39.021C333.484,235.386,334,245.572,334,256z"></path> <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M256,412 c-86.156,0-156-69.844-156-156s69.844-156,156-156c86.156,0,156,69.844,156,156S342.156,412,256,412z"></path> <path d="M216.277,225.531c-1.125,9.901-1.714,20.127-1.714,30.469s0.589,20.568,1.714,30.469h79.447 c1.125-9.901,1.714-20.127,1.714-30.469s-0.589-20.568-1.714-30.469H216.277z"></path> <path d="M313.903,360.516c9.62-5.348,18.555-12.064,26.552-20.061c5.405-5.405,10.221-11.241,14.431-17.424h-28.438 C323.179,336.75,318.939,349.364,313.903,360.516z"></path> </g> </g></svg> </a>
            @if (filament()->auth()->check())
                @if (filament()->hasDatabaseNotifications())
                    @livewire(Filament\Livewire\DatabaseNotifications::class, ['lazy' => true])
                @endif

                <x-filament-panels::user-menu />
            @endif
        </div>

        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::topbar.end') }}
    </nav>
</div>
