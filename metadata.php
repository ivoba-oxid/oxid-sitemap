<?php

declare(strict_types=1);

$sMetadataVersion = '2.1';

$aModule = [
    'id'          => 'ivoba_sitemap',
    'title'       => [
        'de' => 'Ivo Bathke: Sitemap',
        'en' => 'Ivo Bathke: Sitemap',
    ],
    'description' => [
        'de' => 'Erstellt eine Sitemap für die Suchmaschinenoptimierung',
        'en' => 'Generates a sitemap for search engine optimization',
    ],
    'thumbnail'   => 'ivoba-oxid.png',
    'version'     => '4.0.0',
    'author'      => 'Ivo Bathke',
    'email'       => 'hello@ivo-bathke.name',
    'url'         => 'https://github.com/ivoba-oxid/oxid-sitemap',
    'controllers' => [
        'sitemap' => \IvobaOxid\OxidSiteMap\Controller\SitemapController::class,
    ],
    'extend'      => [],
    'blocks'      => [],
    'settings'    => [],
    'events'      => [
        'onActivate'   => 'IvobaOxid\OxidSiteMap\Core\Events::onActivate',
        'onDeactivate' => 'IvobaOxid\OxidSiteMap\Core\Events::onDeactivate',
    ],
];
