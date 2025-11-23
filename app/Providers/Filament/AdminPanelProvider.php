<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Resources\CompanyPolicyResource;
use App\Filament\Resources\CompanyProfileResource;
use App\Filament\Resources\LegalDocumentResource;
use App\Filament\Resources\OrganizationalStructureResource;
use Croustibat\FilamentJobsMonitor\FilamentJobsMonitorPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => '#007601',
            ])
            ->brandName('JLI')
            ->brandLogo(asset('img/jalint.png'))
            ->favicon(asset('img/JLI.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
                  ->navigationGroups([
                      NavigationGroup::make()
                          ->label('Beranda'),
                      //   ->icon('heroicon-o-cog-6-tooth'),
                      NavigationGroup::make()
                          ->label('Tentang Kami')
                          ->items([
                              //   NavigationItem::make('Company Profiles')->url(CompanyProfileResource::getUrl())->sort(1),
                              //   NavigationItem::make('Organizational Structures')->url(OrganizationalStructureResource::getUrl())->sort(2),
                              //   NavigationItem::make('Company Policies')->url(CompanyPolicyResource::getUrl())->sort(3),
                              //   NavigationItem::make('Legal Documents')->url(LegalDocumentResource::getUrl())->sort(4),
                          ]),
                      NavigationGroup::make()
                          ->label('Layanan & Jasa'),
                      NavigationGroup::make()
                          ->label('Lainya'),
                      //   ->icon('heroicon-o-information-circle'),
                      //   ->icon('heroicon-o-document-text'),
                      NavigationGroup::make()
                          ->label('Klien Kami'),
                      //   ->icon('heroicon-o-user-group'),
                      NavigationGroup::make()
                          ->label('Content'),
                  ])
            ->profile()
            ->plugins([
                \Awcodes\Curator\CuratorPlugin::make()
                    ->label('Media')
                    ->pluralLabel('Media')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Content')
                    ->navigationSort(3)
                    ->navigationCountBadge()
                    ->defaultListView('grid' || 'list'),
            ])
            // ->plugin(FilamentSpatieLaravelBackupPlugin::make())
            // ->plugin(FilamentSpatieLaravelHealthPlugin::make())
            // ->plugins([
            //     FilamentJobsMonitorPlugin::make()
            // ])
           // ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
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
            ]);
    }
}
