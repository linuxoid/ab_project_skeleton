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

use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single as SinglePage;

class SinglePages extends BaseClass
{
    public function __construct($pkg)
    {
        parent::__construct($pkg);
    }

    public function install()
    {
        $this->installSinglePages($this->pkg);
    }

    private function installSinglePages($pkg)
    {
        $this->installSinglePage('/dashboard/package_skeleton', t('Package Skeleton'), $pkg);
    }
    
    private function installSinglePage($path, $cName, $pkg)
    {
        $page = Page::getByPath($path);
        if (!is_object($page) || $page->isError()) {
            $page = SinglePage::add($path, $pkg);
            $page->update(array(
                'cName' => $cName,
            ));
        }
    }

    // kept for consistency in loop install/uninstall/upgrade
    public function uninstall()
    {
    }
    
    public function upgrade()
    {
        $this->installSinglePages($this->pkg);
    }

}
