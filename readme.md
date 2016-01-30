# Google Sitemap Exporter

improved Google Sitemap Exporter for Oxid eShop, based on https://github.com/OXIDprojects/google_sitemap

it embraces common code best practices:
- composer
- semver
- tests
- travis
- dependency injection
- namespaces

## Requirements
- Oxid eShop >= 4.9.6
- PHP >= 5.5

## Installation

- run 'composer require ivoba/oxid-sitemap' in modules dir
- copy content of *copy_this* to your shop
- edit sitemap_xml.php to your needs, if necessary

## Usage

call http://yourshop.biz/sitemap_xml.php

## Caution
As oxid-esales/eshop is not on packagist by now, its not listed as composer dependency.  

