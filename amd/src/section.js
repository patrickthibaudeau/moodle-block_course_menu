import $ from 'jquery' ;

export const init = () => {
    $('#id_icongroup_btn_icon').on('click', function () {
        $('#icon-modal').modal('show');
    });

    $('#id_imagegroup_btn_image').on('click', function () {
        $('#image-modal').modal('show');
    });

    $('#id_buttonstylegroup_btn_button_type').on('click', function () {
        $('#button-modal').modal('show');
    });

    $('.fa-hover').on('click', function (e) {
        e.preventDefault();
        let classes = $(this).find('i').attr('class');
        $('#id_icongroup_icon').val(classes);
        $('#id_imagegroup_image').val('');
        $('#icon-modal').modal('hide');
    });

    $('.image-hover').on('click', function (e) {
        e.preventDefault();
        let source = $(this).find('img').attr('src');
        $('#id_imagegroup_image').val(source);
        $('#id_icongroup_icon').val('');
        $('#image-modal').modal('hide');
    });

    $('.btn-select').on('click', function () {
        let source = $(this).data('style');
        $('#id_buttonstylegroup_button_type').val(source);
        $('#button-modal').modal('hide');
    });
};