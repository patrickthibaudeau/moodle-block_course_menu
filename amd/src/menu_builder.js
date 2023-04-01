import $ from 'jquery';
import jqui from 'jqueryui';

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
                // Update order for each course
                // $.ajax({
                //     url: M.cfg.wwwroot + '/local/yulearn/ajax/sort_section_flow_course.php?id=' + itemOrder[i] + '&sort=' + i,
                //     type: 'POST',
                //     success: function(results) {
                //     },
                //     error: function(e) {
                //         alert('An error has occured');
                //     }
                // });
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
                // Update order for each course
                // $.ajax({
                //     url: M.cfg.wwwroot + '/local/yulearn/ajax/sort_section_flow_course.php?id=' + itemOrder[i] + '&sort=' + i,
                //     type: 'POST',
                //     success: function(results) {
                //     },
                //     error: function(e) {
                //         alert('An error has occured');
                //     }
                // });
            }
        }
    });

};