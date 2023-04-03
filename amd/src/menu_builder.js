import $ from 'jquery';
import jqui from 'jqueryui';
import ajax from 'core/ajax';
import ModalFactory from 'core/modal_factory';
import ModalEvents from 'core/modal_events';
import {get_string as getString} from 'core/str';

export const init = () => {
    $('button').on('click', function (e) {
        e.preventDefault();
    })

    $('.sections').sortable({
        cancel: '',
        cursor: 'move',
        opacity: 0.4,
        placeholder: "sections-state-highlight",

        stop: function (event, ui) {
            // Get list order
            var itemOrder = $(this).sortable("toArray");
            // Loop through list
            for (var i = 0; i < itemOrder.length; i++) {
                console.log(i + ")" + itemOrder[i]);
                // Update order for each section
                let updateSortOrder = ajax.call([{
                    methodname: 'block_course_menu_update_section_sort_order',
                    args: {
                        id: itemOrder[i],
                        sort_order: i
                    }
                }]);
                updateSortOrder[0].done(  function () {
                    // Nothing to do here
                });
            }
        }
    });

    $('.grid-list').sortable({
        cancel: '',
        cursor: 'move',
        opacity: 0.4,
        placeholder: "buttons-state-highlight",

        stop: function (event, ui) {
            // Get list order
            var itemOrder = $(this).sortable("toArray");
            // Loop through list
            for (var i = 0; i < itemOrder.length; i++) {
                console.log(i + ")" + itemOrder[i]);
                // Update button sort order
                let updateSortOrder = ajax.call([{
                    methodname: 'block_course_menu_update_button_sort_order',
                    args: {
                        id: itemOrder[i],
                        sort_order: i
                    }
                }]);
                updateSortOrder[0].done(  function () {
                    // Nothing to do here
                });
            }
        }
    });

};