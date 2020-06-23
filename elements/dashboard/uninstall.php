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

<style>
.ab-package-skeleton-uninstall input[type="checkbox"] {
    margin: 0 10px 0 0;
    vertical-align: middle;
    position: relative;
    top: -1px;
}
</style>

<div class="form-group ab-package-skeleton-uninstall">
    <div class="alert alert-danger" role="alert">
        <?php echo t('Delete all Package Skeleton package content from database'); ?>
    </div>
    <input type="checkbox" name="delete_all_content" value="1" />
    <?php echo t('Delete All Content'); ?>
</div>
