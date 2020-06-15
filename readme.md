# Google Sitemap Exporter

[![Build Status][ico-travis]][link-travis]

## Requirements
- Oxid eShop >= 6.2
- PHP >= 7.1

## Installation

Install via composer:

    composer require ivoba-oxid/oxid-sitemap

Activate the plugin:

    vendor/bin/oe-console oe:module:activate ivoba_sitemap

## Usage
Recommended is usage as console command.
### Console
Run:

    vendor/bin/oe-console ivoba-oxid:sitemap:generate

### Browser
Post installation:  
- copy 'sitemap_xml.php' from */vendor/ivoba-oxid/oxid-sitemap/copy_this* to /source/ directory:  
  `cp vendor/ivoba-oxid/oxid-sitemap/copy_this/sitemap_xml.php source/sitemap_xml.php`
- take care that your target file is writeable by the webserver
- create a cronjob that calls http://yourshop.biz/sitemap_xml.php

Sitemap generation can be adjusted by overriding service definition in a module or your projects services.yaml.  

## Todo
- password protect generate page via browser
- compress sitemap
- option to split sitemap, create sitemap_split_xml.php

## Credits
based on https://github.com/OXIDprojects/google_sitemap

## License

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

[link-travis]: https://travis-ci.org/ivoba-oxid/oxid-sitemap
[ico-travis]: https://img.shields.io/travis/ivoba-oxid/oxid-sitemap/master.svg?style=flat-square
