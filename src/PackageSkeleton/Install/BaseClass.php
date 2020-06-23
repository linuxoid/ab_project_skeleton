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

use Concrete\Core\Package\PackageService;
use Concrete\Core\Support\Facade\Application;

class BaseClass
{
    protected $pkg;
    protected $app;

    public function __construct($pkg)
    {
        $this->app = Application::getFacadeApplication();

        if (!is_object($pkg)) {
            $this->pkg = $this->app->make(PackageService::class)->getByHandle($pkg);
        } else {
            $this->pkg = $pkg;
        }
    }
}
