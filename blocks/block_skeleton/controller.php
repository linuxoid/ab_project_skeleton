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

namespace Concrete\Package\AbPackageSkeleton\Block\BlockSkeleton;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Search\Pagination\PaginationFactory;
use Concrete\Core\Http\Request;

use PackageSkeleton\Skeleton\SkeletonList;

class Controller extends BlockController
{
    protected $btTable = 'btAbPackageSkeletonBlockSkeleton';
    protected $btInterfaceWidth = '400';
    protected $btInterfaceHeight = '300';
    protected $btWrapperClass = 'ccm-ui';
    protected $btDefaultSet = 'block_skeleton';

    protected $form_errors = array();
    protected $form_success = array();
    
    public function getBlockTypeDescription()
    {
        return t('Add Block Skeleton to the Page');
    }

    public function getBlockTypeName()
    {
        return t('Block Skeleton');
    }
    
    public function on_start() {
        $this->set('app', $this->app);
    }
        
    public function registerViewAssets($outputContent = '')
    {
        $this->requireAsset('javascript', 'jquery');
    }
    
    public function view()
    {
        $skeletons = new SkeletonList();
        $skeletons->setItemsPerPage($this->num);

        $sort = $this->request->query->get('sort' . $this->bID);

        if ($sort && $sort != '0') {
            $skeletons->setSortBy($sort);
            $this->set('usersort', $sort);
        } else {
            $skeletons->setSortBy('name_asc');
            $this->set('usersort', '');
        }
        
        $service = $this->app->make('helper/security');
        $keywords = array();
        if ($this->request->query->get('keywords')) { $keywords['search'] = $service->sanitizeString($this->request->query->get('keywords')); }
        $skeletons->setCustomSearch($keywords);
        
        $factory = new PaginationFactory($this->app->make(Request::class));
        $paginator = $factory->createPaginationObject($skeletons);
        $pagination = $paginator->renderDefaultView();
        $this->set('skeletons', $paginator->getCurrentPageResults());
        $this->set('pagination', $pagination);
        $this->set('paginator', $paginator);
    }

    public function add()
    {
        $this->set('num', 10);
    }

    public function edit()
    {
        
    }

    public function save($data)
    {
        $data['num'] = isset($data['num']) ? $data['num'] : 10;
        $data['title'] = isset($data['title']) ? $data['title'] : '';
        parent::save($data);
    }

    public function validate($data)
    {
        $e = $this->app->make('helper/validation/error');
        
        $title = trim($data['title']);
        
        if ($title == '' || mb_strlen($title, 'UTF-8') > 255) {
            $e->add(t('Name cannot be empty and must have max 255 symbols'));
        }
        
        return $e;        
    }
}

