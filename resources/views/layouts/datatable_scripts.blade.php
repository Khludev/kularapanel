<script type="text/javascript">
(function(window, $) {
    let filterBtnHtml = '<button type="button" class="btn btn-outline-secondary btn-sm mr-1" data-toggle="modal" data-target="#filterModalCenter"><i class="fal fa-search mr-2"></i>Advanced Filter</button>';
    let exportBtnHtml = '<button type="button" class="btn btn-outline-secondary btn-sm" id="exportBtn"><i class="fal fa-file-spreadsheet mr-2"></i>Export</button>';
    let toolbarHtml = '<div class="float-right">';
    toolbarHtml = toolbarHtml + filterBtnHtml;
    @if (isset($export_url) && $export_url != '')
    toolbarHtml = toolbarHtml + exportBtnHtml;
    @endif
    toolbarHtml = toolbarHtml + '</div>';

    $("div.toolbar").html(toolbarHtml);
    $(document).on('click', '#filterBtn', function(event) {
        event.preventDefault();
        window.LaravelDataTables['{{ $dtid }}'].draw();
        $('#filterModalCenter').modal('hide');
    });
    @if (isset($export_url) && $export_url != '')
    $(document).on('click', '#exportBtn', function(event) {
        event.preventDefault();
        let data = {};
        $('.filterInput').each(function(index) {
            data[$(this).attr('name')] = $(this).val();
        });
        window.open('{{ $export_url }}' + '?filter='+ JSON.stringify(data),'_export');
        window.LaravelDataTables['{{ $dtid }}'].draw();
        $('#filterModalCenter').modal('hide');
    });
    @endif
})(window, jQuery);
</script>