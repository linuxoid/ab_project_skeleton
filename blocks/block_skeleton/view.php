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

?>

<div class="ab-package-skeleton-block-skeleton">                        

    <div class="ab-package-skeleton-block-skeleton-form">
        <form id="package_skeleton_block_skeleton_form">
            <a class="ab-package-skeleton-block-skeleton-advanced-search-a show-hide pull-right"><?php echo t('Show Advanced Filter / Search Options'); ?><i class="fa fa-angle-down"></i></a>
            <div class="ab-package-skeleton-block-skeleton-advanced-search top">
                <div class="row">
                    <div class="ab-package-skeleton-search">
                        <div class="col-sm-6 col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </div>
                                <?php echo $form->search('keywords', $searchRequest['keywords'], ['placeholder' => t('Search by Name')]); ?>
                            </div>
                        </div>
                    </div>
                        
                    <div class="ab-package-skeleton-sort">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group form-select form-sort">
                                <?php 
                                echo $form->select('sort'. $bID,
                                    array(
                                        '0' => t('Sort by Name Ascending'),
                                        'name_desc' => t('Sort by Name Descending'),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                    $(function () {
                        $('#sort<?php echo $bID; ?>').change(function(){
                            var sortstring = '<?php echo $app->make('helper/url')->setVariable(array('sort'. $bID=>'%sort%')); ?>';
                            window.location.href = sortstring.replace('%sort%', $(this).val());
                        });
                    });
                    </script>
                </div>
                
                <a class="ab-package-skeleton-block-skeleton-advanced-search show-hide bottom pull-right"><?php echo t('Hide Advanced Filter / Search Options'); ?><i class="fa fa-angle-up"></i></a>
                
                <div class="form-group buttons">
                    <?php echo $form->submit('package_skeleton_block_skeleton_form_submit', t('Search'), array ('class'=>"btn btn-default")); ?>
                    <?php echo $form->button('package_skeleton_block_skeleton_form_clear', t('Clear'), array ('class'=>"btn btn-sm btn-default")); ?>
                </div>
            </div>
            
            <script type="text/javascript">
                $(function(){
                    $(".ab-package-skeleton-block-skeleton-form").on('click', '.show-hide', function(e) {
                        switch($(this).text()) {
                            case '<?php echo t('Show Advanced Filter / Search Options'); ?>':
                                $(this).next().fadeToggle(500, 'linear');
                                $(this).replaceWith('<h3 class="ab-package-skeleton-block-skeleton-advanced-search-a show-hide"><?php echo t('Advanced Filter / Search Options'); ?>:</h3>');
                                break;
                            case '<?php echo t('Hide Advanced Filter / Search Options'); ?>':
                                $(this).parent().fadeToggle(500, 'linear');
                                $(this).parent().prev().replaceWith('<a class="ab-package-skeleton-block-skeleton-advanced-search-a show-hide pull-right"><?php echo t('Show Advanced Filter / Search Options'); ?><i class="fa fa-angle-down"></i></a>');
                                break;
                        }
                    });
                    $(".ab-package-skeleton-block-skeleton-form").on('click', '.show-hide.bottom', function(e) {
                        $('html, body').animate({scrollTop: 0}, 300);
                    });
                });
            </script>
        </form>
    </div>
    
    <div class="ab-package-skeleton-block-skeleton-list">
        <h1><?php echo $title; ?></h1>
        
        <?php 
        if (is_array($skeletons) && count($skeletons) > 0) {
            foreach ($skeletons as $skeleton) {
            ?>
                <div class="ab-package-skeleton-block-skeleton-list-name">
                    <?php echo t($skeleton->getName()); ?>
                </div>
            <?php
            }
            
            if ($paginator && $paginator->getTotalPages() > 1) {
            ?>
                <div class="ccm-search-results-pagination">
                    <?php echo $pagination; ?>
                </div>
            <?php
            }
        }
        else {
        ?>
            <div class="alert alert-danger" role="alert">
                <?php echo t('No item found'); ?>
            </div>             
        <?php } ?>
    </div>
    
</div>
