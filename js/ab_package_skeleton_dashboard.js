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

$(function(){
    
    var url = window.location.pathname.toString();

    $('[data-toggle="tooltip"]').tooltip();
    
    $('.confirm-action').click(function(e) {
        e.preventDefault();
        ConcreteAlert.confirm(
            $(this).data('confirm-message'),
            function() {
                $(this).closest('form').submit();
            }
        );
    });

    $('#btn_delete').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        ConcreteAlert.confirm(
            $(this).data('confirm-message'),
            function() {
                window.location = url+'/';
            },
            'btn-danger',
        );
    });
    
    $('.btn-delete-xs').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        ConcreteAlert.confirm(
            $(this).data('confirm-message'),
            function() {
                window.location = url+'/';
            },
            'btn-danger',
        );
    });
});

