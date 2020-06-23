/**
 * Business Listing package for Concrete5
 *
 * concrete5.org marketplace license
 * 
 * @author Alex Borisov <linuxoidoz@gmail.com>
 * @copyright 2018-2019, Alex Borisov
 * @package Concrete\Package\ab_business_listing
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

