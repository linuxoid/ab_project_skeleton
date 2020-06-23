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

namespace PackageSkeleton\Install;

use Concrete\Core\Http\Request;
use Concrete\Core\Support\Facade\DatabaseORM;
use Concrete\Core\Database\DatabaseStructureManager;

use PackageSkeleton\Skeleton\Skeleton;

class Installer extends BaseClass
{
    protected $installers;
    
    public function __construct($pkg)
    {
        parent::__construct($pkg);

        $this->installers = [
            new SinglePages($this->pkg),
            new Blocks($this->pkg),
        ];
    }
    
    public function install()
    {
        foreach ($this->installers as $installer) {
            $installer->install();
        }
    }
   
    public function uninstall()
    {
        foreach ($this->installers as $installer) {
            $installer->uninstall();
        }
        
        $r = $this->app->make(Request::class);
        if ($r->request->get('delete_all_content')) {
            $this->DeleteAllContent();
        }
    }

    public function upgrade()
    {
        foreach ($this->installers as $installer) {
            $installer->upgrade();
        }
        
        $this->app->clearCaches();
        $this->RefreshEntities();
    }

    public function DeleteAllContent()
    {
        $object_array = [
            Skeleton::getSkeletonList(),
        ];
        foreach ($object_array as $objects) {
            if (is_array($objects) && count($objects) > 0) {
                foreach ($objects as $object) {
                    if ($object) {
                        $object->remove();
                    }
                }
            }
        }
    }

    public function RefreshEntities()
    {
        $em = DatabaseORM::entityManager();
        $manager = new DatabaseStructureManager($em);
        $manager->refreshEntities();
    }

}
