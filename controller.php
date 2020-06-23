<?php

/**
 * Package Skeleton package for Concrete5
 * Copyright 2020, Alex Borisov. All Rights Reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Alex Borisov <linuxoidoz@gmail.com>
 * @copyright 2020, Alex Borisov. All Rights Reserved.
 * @package Concrete\Package\ab_package_skeleton
 */
 
namespace Concrete\Package\AbPackageSkeleton;

use Concrete\Core\Package\Package;
use Concrete\Core\Package\PackageService;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Database\EntityManager\Provider\ProviderAggregateInterface;
use Concrete\Core\Database\EntityManager\Provider\StandardPackageProvider;

use PackageSkeleton\Install\Installer;

class Controller extends Package implements ProviderAggregateInterface
{
    protected $pkgHandle = 'ab_package_skeleton';
    protected $appVersionRequired = '8.3.2';
    protected $pkgVersion = '0.9.0';
    protected $pkgAutoloaderRegistries = [
        'src/PackageSkeleton' => 'PackageSkeleton'
    ];
    
    public function getPackageDescription() 
    {
        return t('Package Skeleton package');
    }
    
    public function getPackageName() 
    {
        return t('Package Skeleton');
    }
    
    public function getEntityManagerProvider()
    {
        $provider = new StandardPackageProvider($this->app, $this, [
            'src/PackageSkeleton' => 'PackageSkeleton'
        ]);
        return $provider;
    }
    
    // Get user entered strings for translation in Multilingual -> Translate Site Interface
    public function getTranslatableStrings(\Gettext\Translations $translations)
    {/*
        $columns = [
            'AbPackageSkeletonClassSkeletons' => 'name',
            'Config' => 'configValue',
        ];
        
        $db = $this->app->make('database')->connection();
        foreach ($columns as $table => $column) {
            $rs = $db->executeQuery('select ' . $column . ' from ' . $table);
            while (($word = $rs->fetchColumn()) !== false) {
                $translations->insert('', $word);
            }
        }
        
        // Uncomment the line below if the main default locale is NOT English, then reload strings in the Multilingual Site Interface Translation
        //$this->app->make('config')->save('concrete.misc.enable_translate_locale_base_locale', true);
    */}
    
    public function on_start()
    {
        $al = AssetList::getInstance();
        $al->register('javascript', 'ab_package_skeleton_dashboard', 'js/ab_package_skeleton_dashboard.js', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => false, 'combine' => false), $this);
        $al->register('css', 'ab_package_skeleton_dashboard', 'css/ab_package_skeleton_dashboard.css', array('version' => '1', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => false, 'combine' => false), $this);
    }
    
    public function install() 
    {
        $pkg = parent::install();
        $installer = new Installer($pkg);
        $installer->install();
    }

    public function uninstall()
    {
        $pkg = $this->app->make(PackageService::class)->getByHandle($this->pkgHandle);

        $installer = new Installer($pkg);
        $installer->uninstall();

        parent::uninstall();
    }
    
    public function upgrade()
    {
        parent::upgrade();

        $pkg = $this->app->make(PackageService::class)->getByHandle($this->pkgHandle);

        $installer = new Installer($pkg);
        $installer->upgrade();
    }
    
}
