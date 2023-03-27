import $ from 'jquery';
import ajax from 'core/ajax';

// Move block_course_menu to the end of section 0
export const init = () => {
    if ($('#show_in_section_zero').val() == 1) {
        $('.block_course_menu').detach().appendTo('#coursecontentcollapse0');
    }

    $('#course-menu-show-section-zero').on('click',function() {
        let id = $(this).data('id');
        if ($(this).is(':checked')) {
            let updateSectionZero = ajax.call([{
                methodname: 'block_course_menu_update_section_zero',
                args: {
                    id: id,
                    value: 1
                }
            }]);
            updateSectionZero[0].done(  function (response) {
                location.reload();
            });
        } else {
            let updateSectionZero = ajax.call([{
                methodname: 'block_course_menu_update_section_zero',
                args: {
                    id: id,
                    value: 0
                }
            }]);
            updateSectionZero[0].done(  function (response) {
                location.reload();
            });
        }
    })
};