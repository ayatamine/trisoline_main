<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Firefly\FilamentBlog\Blog;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Request;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Admin\Resources\StepResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Admin\Resources\ProjectResource;
use App\Filament\Admin\Resources\ServiceResource;
use App\Filament\Admin\Resources\SettingResource;
use App\Filament\Admin\Resources\TestimonialResource;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use SolutionForest\FilamentAccessManagement\FilamentAccessManagementPanel;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->login(\Filament\Pages\Auth\Login::class)
            // ->spa()
            // ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            //     return $builder->items([
            //         NavigationItem::make('Dashboard')
            //         ->icon('heroicon-o-home')
            //         ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
            //         ->url(fn (): string => Dashboard::getUrl()),
            //         NavigationItem::make('Settings')
            //             ->icon('icon-settings')
            //             ->url(SettingResource::getUrl('edit',[1])	)
            //             ->isActiveWhen(fn (): bool => Request::segment(2) == "settings"),
            //         NavigationItem::make('Services')
            //             ->icon('icon-services')
            //             ->url(ServiceResource::getUrl('index')	)
            //             ->isActiveWhen(fn (): bool => Request::segment(2) == "services"),
            //         NavigationItem::make('Steps')
            //             ->icon('icon-steps')
            //             ->url(StepResource::getUrl('index')	)
            //             ->isActiveWhen(fn (): bool => Request::segment(2) == "steps"),
            //         NavigationItem::make('Projects')
            //             ->icon('icon-portfolio')
            //             ->url(ProjectResource::getUrl('index')	)
            //             ->isActiveWhen(fn (): bool => Request::segment(2) == "projects"),
            //         NavigationItem::make('Testimonials')
            //             ->icon('icon-testimonials')
            //             ->url(TestimonialResource::getUrl('index')	)
            //             ->isActiveWhen(fn (): bool => Request::segment(2) == "testimonials"),
            //     ]);
            // })
            
            ->userMenuItems([
                MenuItem::make()
                    ->label('Settings')
                    ->url(fn (): string => SettingResource::getUrl('edit',[1]))
                    ->icon('icon-settings'),

                // ...
            ])
            ->plugins([
                Blog::make()
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->default()
            ->viteTheme('resources/css/filament/client/theme.css')
            ->plugin(FilamentAccessManagementPanel::make());;
    }
}
