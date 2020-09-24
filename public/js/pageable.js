/**
 * Widget adding a pager to a table
 * inspired by https://stackoverflow.com/a/28206715
 * @param {string} selector 
 */
const pageable = (selector) => {

    $(selector).after('<div id="pager-number" class="paging-wrapper"></div>');
    let visibleRowsNumber = 50
    let tableRowsNumber = $(`${selector} tbody tr`).length;
    let pageNumber = tableRowsNumber / visibleRowsNumber
    for (i = 0; i < pageNumber; i++) {
        $('#pager-number').append('<a href="#" rel="' + i + '">' + (i + 1) + '</a>');
    }

    $(`${selector} tbody tr`).hide();
    $(`${selector} tbody tr`).slice(0, visibleRowsNumber).show();
    $('#pager-number a:first').addClass('active');
    $('#pager-number a').on('click', function (e) {
        e.preventDefault();
        $('#pager-number a').removeClass('active');
        $(item).addClass('active');
        let currPage = $(item).attr('rel');
        let startItem = currPage * visibleRowsNumber;
        let endItem = startItem + visibleRowsNumber;
        $(`${selector} tbody tr`).css('opacity', '0.0').hide().slice(startItem, endItem).
        css('display', 'table-row').animate({
            opacity: 1
        }, 300);

    });




}