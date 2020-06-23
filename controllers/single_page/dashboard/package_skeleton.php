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
 * @package Concrete\Package\ab_package_skeletons
 */

namespace Concrete\Package\AbPackageSkeleton\Controller\SinglePage\Dashboard;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Search\Pagination\PaginationFactory;
use Concrete\Core\Routing\Redirect;
use Concrete\Core\Http\Request;

use PackageSkeleton\Skeleton\Skeleton;
use PackageSkeleton\Skeleton\SkeletonList;
use PackageSkeleton\MyFunctions;

class PackageSkeleton extends DashboardPageController
{
    public function on_start()
    {
        $this->set('app', $this->app);
    }
        
    public function view($id = null)
    {
        $this->LoadFormAssets();
        
        $skeletons = new SkeletonList();
        $skeletons->setItemsPerPage(10);

        if ($this->request->query->get('ccm_order_by')) {
            $skeletons->setSortBy($this->request->query->get('ccm_order_by'));
            $skeletons->setSortByDirection($this->request->query->get('ccm_order_by_direction'));
        } else {
            $skeletons->setSortBy('name_asc');
        }

        if ($this->request->query->get('keywords')) {
            $skeletons->setSearch(trim($this->request->query->get('keywords')));
        }

        $this->set('skeleton_list', $skeletons);
        $factory = new PaginationFactory($this->app->make(Request::class));
        $paginator = $factory->createPaginationObject($skeletons);
        $pagination = $paginator->renderDefaultView();
        $this->set('skeletons', $paginator->getCurrentPageResults());
        $this->set('pagination', $pagination);
        $this->set('paginator', $paginator);
    }
    
    public function success()
    {
        $this->set('success', t('Skeleton Added'));
        $this->view();
    }
    
    public function updated()
    {
        $this->set('success', t('Skeleton Updated'));
        $this->view();
    }
    
    public function removed()
    {
        $this->set('success', t('Skeleton Removed'));
        $this->view();
    }
    
    public function add()
    {
        $this->LoadFormAssets();
        $this->set('action_type', t('Add'));
    }
    
    public function edit($id = 0, $status = '')
    {
        if ($status == 'updated') {
            $this->set('success', t('Skeleton Updated'));
        }

        if ($status == 'added') {
            $this->set('success', t('Skeleton Added'));
        }

        $this->LoadFormAssets();
        $this->set('action_type', t('Update'));
        
        $skeleton = Skeleton::getByID($id);
        if (!$skeleton) {
            $r = Redirect::to('/dashboard/package_skeleton');
            $r->send();
            exit;
        }

        $this->set('skeleton', $skeleton);
    }

    public function delete($id = 0)
    {
        $skeleton = Skeleton::getByID($id);
        if ($skeleton) {
            $skeleton->remove();
        }
        $r = Redirect::to('/dashboard/package_skeleton/removed');
        $r->send();
        exit;
    }
    
    public function LoadFormAssets()
    {
        $this->requireAsset('css', 'ab_package_skeleton_dashboard');
        $this->requireAsset('javascript', 'ab_package_skeleton_dashboard');
    }
    
    public function save()
    {
        $data = $this->request->request->all();
        if ($data['id']) {
            $this->edit($data['id']);
        } else {
            $this->add();
        }
        if ($data) {
            $errors = $this->validate($data);
            $this->error = null;
            $this->error = $errors;
            if (!$errors->has()) {

                //save the skeleton
                $skeleton = Skeleton::saveSkeleton($data);
                
                if ($data['id']) {
                    $r = Redirect::to('/dashboard/package_skeleton/edit/' . $skeleton->getID(), 'updated');
                    $r->send();
                    exit;
                } else {
                    $r = Redirect::to('/dashboard/package_skeleton/edit/' . $skeleton->getID(), 'added');
                    $r->send();
                    exit;
                }
            }
        }
    }
    
    public function validate($data)
    {
        $e = $this->app->make('helper/validation/error');
        
        $name = trim($data['name']);
        
        if ($name == '' || mb_strlen($name, 'UTF-8') > 255) {
            $e->add(t('Name cannot be empty and must have max 255 symbols'));
        }
        
        return $e;        
    }
    
}
