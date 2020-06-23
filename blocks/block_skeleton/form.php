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
.text-muted {
    font-size: 0.8em;
}

.need {
    display: inline-block;
    text-align: left;
    margin: 0 auto;
    margin-left: 10px;
    color: #ff4100;
    font-size: 0.7em;
    font-weight: 400;
    opacity: 0.5;
}
</style>

<fieldset class="ab-package-skeleton-block-skeleton-form">

    <div class="form-group">
        <?php
        echo $form->label('title', t('Title Text') . '<span class="need">' . t('Required') . '</span>');
        echo $form->text('title', $title, ['maxlength' => 255]);
        echo '<p class="text-muted">' . t('Max 255 symbols') . '</p>';
        ?>
    </div>
    
    <div class="form-group">
        <?php
        echo $form->label('num', t('Number of List Items per Page'));
        echo $form->number('num', $num ? $num : 10, ['min' => '3', 'max' => '100', 'class' => "decimals"]);
        echo '<p class="text-muted">' . t('Values from 3 to 100') . '</p>';
        ?>
    </div>
    
</fieldset>

<?php echo $form->hidden('decimals_error', '', ['data-error-title' => t('Oops!'), 'data-error-message' => t('Numbers only')]); ?>

<script type="text/javascript">
$(function() {
    $('#ccm-form-submit-button').on('click', function(e) {
        // Input validation
    });
    
    var error_title = $('#decimals_error').attr('data-error-title');
    var error_message = $('#decimals_error').attr('data-error-message');
    var ctrl_key_pressed = false;
    $('.decimals').keydown(function (e) {
        if (e.ctrlKey === true || e.metaKey === true) {
            ctrl_key_pressed = true;
        }
        // Allow: ctrl, backspace, delete, tab, escape, enter, - and .
        if ($.inArray(e.keyCode, [17, 8, 46, 9, 27, 13, 109, 173, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Ctrl+C, Ctrl+V
            (ctrl_key_pressed && (e.keyCode == 65 || e.keyCode == 67 || e.keyCode == 86)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 ctrl_key_pressed = false;
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
            ConcreteAlert.error({
                title: error_title,
                message: error_message,
            });
        }
    });
});
</script>
