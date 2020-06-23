<?php defined('C5_EXECUTE') or die("Access Denied.");

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

use Concrete\Core\Support\Facade\Url;

use PackageSkeleton\Skeleton\Skeleton;

$list_views = array('view','updated','removed','success');
$add_views = array('add','edit','save');

?>

<?php if (in_array($controller->getAction(), $add_views)) {
    if(!is_object($skeleton)) {
        $skeleton = new Skeleton();
    }

    $id = $skeleton->getID();
 ?>

    <?php if ($id > 0) { ?>
    <div class="ccm-dashboard-header-buttons">
        <a data-confirm-message="<?php echo h(t('Delete this skeleton?')); ?>" href="<?php echo Url::to('/dashboard/package_skeleton/delete', $id); ?>" class="btn btn-danger" id="btn_delete"><?php echo t('Delete Skeleton'); ?></a>
        <a href="<?php echo Url::to('/dashboard/package_skeleton', 'add'); ?>" class="btn btn-primary"><?php echo t('Add Skeleton'); ?></a>
    </div>
    <?php } ?>
    
    <div class="form-group">
        <?php 
        echo $app->make('helper/concrete/ui')->tabs([
            ['options', t('Options'), true],
            ['description', t('Description')],
            ['images', t('Images')],
        ]);
        ?>
    </div>

    <form method="post" action="<?php echo $view->action('save'); ?>">
        <?php echo $form->hidden('id', $id); ?>
        
        <div class="form-group">
            <?php 
            echo $form->label('name', t('Name') . '<span class="need">' . t('Required') . '</span>');
            echo $form->text('name', $skeleton->getName(), ['maxlength' => 255]);
            echo '<p class="text-muted">' . t('Max 255 symbols') . '</p>';
            ?>
        </div>
        
        <div id="ccm-tab-content-options" class="ccm-tab-content">
            <h4><?php echo t('Options'); ?></h4>
        </div><!-- options -->

        <div id="ccm-tab-content-description" class="ccm-tab-content">
            <h4><?php echo t('Description'); ?></h4>
        </div><!-- description -->

        <div id="ccm-tab-content-images" class="ccm-tab-content">
            <h4><?php echo t('Images'); ?></h4>
        </div><!-- images -->

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?php echo Url::to('/dashboard/package_skeleton'); ?>" class="btn btn-default pull-left"><?php echo t('Cancel / View All Skeleton Listing'); ?></a>
                <button class="pull-right btn btn-success" id="action" type="submit"><?php echo t('%s Skeleton', $action_type); ?></button>
            </div>
        </div>

        <script type="text/javascript">
        $(function() {
            $('#action').on('click', function(e){
                // Validate inputs
            });
        });
        </script>

    </form>

<?php } elseif (in_array($controller->getAction(), $list_views)) { ?>

    <div class="ccm-dashboard-header-buttons">
        <a href="<?php echo Url::to('/dashboard/package_skeleton', 'add'); ?>" class="btn btn-primary"><?php echo t('Add Skeleton'); ?></a>
    </div>

    <div class="ccm-dashboard-content-full">
        <form role="form" class="form-inline ccm-search-fields">
            <div class="ccm-search-fields-row ccm-search-fields-submit">
                <div class="form-group">
                    <div class="ccm-search-main-lookup-field">
                        <i class="fa fa-search"></i>
                        <?php echo $form->search('keywords', $searchRequest['keywords']); ?>
                    </div>

                </div>
                <button type="submit" class="btn btn-default"><?php echo t('Search'); ?></button>
                <p class="text-muted"><?php echo t('Search by Name'); ?></p>
            </div>
        </form>

        <table class="ccm-search-results-table">
            <thead>
                <tr>
                    <th><a href="<?php echo $skeleton_list->getSortURL('name'); ?>"><?php echo t('Name'); ?></a></th>
                    <th><?php echo t('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>

            <?php if (is_array($skeletons) && count($skeletons) > 0) {
                foreach ($skeletons as $skeleton) {
                    ?>
                    <tr>
                        <td><strong><a href="<?php echo Url::to('/dashboard/package_skeleton/edit', $skeleton->getID()); ?>"><?php echo t($skeleton->getName()); ?></a></strong></td>
                        <td>
                            <a class="btn btn-primary btn-xs" href="<?php echo Url::to('/dashboard/package_skeleton/edit', $skeleton->getID())?>" title="<?php echo t('Edit'); ?>"><i class="fa fa-pencil"></i></a>
                            <a data-confirm-message="<?php echo h(t('Delete this skeleton?')); ?>" href="<?php echo Url::to('/dashboard/package_skeleton/delete', $skeleton->getID()); ?>" title="<?php echo t('Delete'); ?>" class="btn btn-danger btn-xs btn-delete-xs"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php }
            }?>
            </tbody>
        </table>

        <?php if ($paginator && $paginator->getTotalPages() > 1) { ?>
            <div class="ccm-search-results-pagination">
                <?php echo $pagination; ?>
            </div>
        <?php } ?>

    </div>

<?php } ?>
