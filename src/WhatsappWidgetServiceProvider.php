<?php

namespace JeffersonGoncalves\WhatsappWidget;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WhatsappWidgetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('whatsapp-widget')
            ->hasMigration('create_whatsapp_agents_table')
            ->hasConfigFile('whatsapp-widget')
            ->hasAssets()
            ->hasViews()
            ->hasTranslations()
            ->hasRoute('whatsapp-widget');
    }
}
