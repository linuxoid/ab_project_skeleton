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

use Concrete\Core\Search\Pagination\Pagination;
use Concrete\Core\Search\ItemList\Database\ItemList;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Doctrine\DBAL\Query\QueryBuilder;
use Concrete\Core\Support\Facade\DatabaseORM;
use Concrete\Core\Support\Facade\Application;

class SkeletonList extends ItemList
{
    protected $autoSortColumns = [
        'c.name',
    ];
    protected $sortBy = "name";
    protected $sortByDirection = "asc";

    public function setSortBy($sort)
    {
        $this->sortBy = $sort;
    }

    public function setSortByDirection($dir)
    {
        $this->sortByDirection = $dir;
    }

    public function getSortByDirection() {
        return $this->sortByDirection;
    }

    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function setCustomSearch($custom_search)
    {
        $this->custom_search = $custom_search;
    }

    public function createQuery()
    {
        $this->query->select('c.id')
            ->from('AbPackageSkeletonSkeletons', 'c');
    }
    
    public function finalizeQuery(QueryBuilder $query)
    {
        $paramcount = 0;
        
        switch ($this->sortBy) {
            case "name":
                $query->orderBy('c.name', $this->getSortByDirection());
                break;
            case "name_asc":
                $query->orderBy('c.name', 'asc');
                break;
            case "name_desc":
                $query->orderBy('c.name', 'desc');
                break;
        }
        
        if ($this->search) {
            $query->andWhere('c.name like ?')->setParameter($paramcount++, '%' . $this->search . '%');
        }
        elseif (is_array($this->custom_search)) {
            if (!empty($this->custom_search['search'])) {
                $query->andWhere('c.name like ?')->setParameter($paramcount++, '%' . $this->custom_search['search'] . '%');
            }
        }
        
        return $query;        
    }
    
    public function getTotalResults()
    {
        $query = $this->deliverQueryObject();
        $query
            ->resetQueryParts(['groupBy', 'orderBy'])
            ->select('count(distinct c.id)')
            ->setMaxResults(1);
        $result = $query->execute()->fetchColumn();
        return (int) $result;
    }
    
    protected function createPaginationObject()
    {
        $adapter = new DoctrineDbalAdapter(
            $this->deliverQueryObject(),
            function (QueryBuilder $query) {
                $query
                    ->resetQueryParts(['groupBy', 'orderBy'])
                    ->select('count(distinct c.id)')
                    ->setMaxResults(1);
            }
        );
        $pagination = new Pagination($this, $adapter);
        return $pagination;
    }
    
    public function getResult($queryRow)
    {
        return Skeleton::getByID($queryRow['id']);
    }
}
