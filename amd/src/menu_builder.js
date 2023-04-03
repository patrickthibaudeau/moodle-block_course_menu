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
                updateSortOrder[0].done(function () {
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
                updateSortOrder[0].done(function () {
                    // Nothing to do here
                });
            }
        }
    });

    // Delete button
    $('.delete-item').on('click', function () {
        let id = $(this).data('id');

        ModalFactory.create({
            type: ModalFactory.types.SAVE_CANCEL,
            title: getString('delete_button', 'block_course_menu'),
            body: getString('delete_button_help', 'block_course_menu')
        }).then(function (modal) {

            modal.setSaveButtonText(getString('yes', 'block_course_menu'));

            modal.getRoot().on(ModalEvents.save, function () {
                var deleteButton = ajax.call([{
                    methodname: 'block_course_menu_delete_button',
                    args: {
                        id: id
                    }
                }]);

                deleteButton[0].done(function (response) {
                    return location.reload();
                }).fail(function (ex) {
                    alert('An error has occurred. The record was not saved');
                });
            });

            console.log(ModalEvents);
            modal.getRoot().on(ModalEvents.cancel, function () {
                // CLose modal
            });

            /**
             * Open the modal and run some jQuery
             * for the campusLanguages so that select2 works
             */
            modal.show();
        });
    });

    // Delete section
    $('.delete-section').on('click', function () {
        let id = $(this).data('sectionid');

        ModalFactory.create({
            type: ModalFactory.types.SAVE_CANCEL,
            title: getString('delete_section', 'block_course_menu'),
            body: getString('delete_section_help', 'block_course_menu')
        }).then(function (modal) {

            modal.setSaveButtonText(getString('yes', 'block_course_menu'));

            modal.getRoot().on(ModalEvents.save, function () {
                var deleteSection = ajax.call([{
                    methodname: 'block_course_menu_delete_section',
                    args: {
                        id: id
                    }
                }]);

                deleteSection[0].done(function (response) {
                    return location.reload();
                }).fail(function (ex) {
                    alert('An error has occurred. The record was not saved');
                });
            });

            console.log(ModalEvents);
            modal.getRoot().on(ModalEvents.cancel, function () {
                // Close Modal
            });

            /**
             * Open the modal and run some jQuery
             * for the campusLanguages so that select2 works
             */
            modal.show();
        });
    });
};