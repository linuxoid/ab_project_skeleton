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

namespace PackageSkeleton\Skeleton;

use Concrete\Core\Package\PackageService;
use Doctrine\ORM\Mapping as ORM;
use Concrete\Core\Support\Facade\DatabaseORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="AbPackageSkeletonSkeletons")
 */
class Skeleton
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    public function getID()
    {
        return $this->id;
    }

    public function setID($id)
    {
        $this->id = $id;
    }
    
    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    protected $name;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public static function getByID($id)
    {
        $em = DatabaseORM::entityManager();
        return $em->find(get_class(), $id);
    }

    public static function getByName($name)
    {
        $em = DatabaseORM::entityManager();
        return $em->getRepository(get_class())->findOneBy(array('name' => $name));
    }

    public static function saveSkeleton($data)
    {
        if ($data['id']) {
            //if we know the id, we're updating.
            $name = self::getByID($data['id']);
        } else {
            //else, we don't know it and we're adding a new name
            $name = new self();
        }
        $name->setName($data['name']);
        
        $name->save();

        return $name;
    }

    public function save()
    {
        $em = DatabaseORM::entityManager();
        $em->persist($this);
        $em->flush();
    }

    public function delete() {
        $em = DatabaseORM::entityManager();
        $em->remove($this);
        $em->flush();
    }

    public function remove()
    {
        $this->delete();
    }
    
    public function getSkeletonList()
    {
        $em = DatabaseORM::entityManager();
        return $em->getRepository(get_class())->findBy(array(), array('name' => 'asc'));
    }

    // kept for consistency in loop install/uninstall/upgrade
    public function install()
    {
    }
    
    // kept for consistency in loop install/uninstall/upgrade
    public function uninstall()
    {
    }
    
    // kept for consistency in loop install/uninstall/upgrade
    public function upgrade()
    {
    }

}
