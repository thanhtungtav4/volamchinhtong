(function ($) {
    'use strict';

    function migragePrettyLinks(params) {

        var start = params.start;
        var batch = params.batch;
        var limit = params.limit;
        var security = params.security;
        var data = {
            action: 'us_handle_request',
            cmd: "import_pretty_links",
            start: start,
            batch: batch,
            limit: limit,
            security: security
        };

        sendRequest(data).then(function (resposne) {
            if (response.status === "success") {
                migragePrettyLinks();
            } else {
                console.log('Some error occured!');
            }
        });
    }


    $(document).ready(function () {

        if ($('.group_select').length) {
            var group_select = $('.group_select')[0].outerHTML;
        }

        $(".kc-us-items-lists .bulkactions #bulk-action-selector-top").after(group_select);

        $('.group_select').hide();

        $("#bulk-action-selector-top").change(function () {
            if ($('option:selected', this).attr('value') == 'bulk_group_move' || $('option:selected', this).attr('value') == 'bulk_group_add') {
                $('.group_select').eq(1).show();
            } else {
                $('.group_select').hide();
            }
        });

        // When we click outside, close the dropdown
        $(document).on("click", function (event) {
            var $trigger = $("#kc-us-create-button");
            if ($trigger !== event.target && !$trigger.has(event.target).length) {
                $("#kc-us-create-dropdown").hide();
            }
        });

        // Toggle Dropdown
        $('#kc-us-create-button').click(function () {
            $('#kc-us-create-dropdown').toggle();
        });

        // Clicks Reports Datatable
        if ($('#clicks-data').get(0)) {

            var sortIndex = $('#clicks-data').find("th[data-key='clicked_on']")[0].cellIndex;

            if ($('#clicks-data').get(0)) {
                $('#clicks-data').DataTable({
                    order: [[sortIndex, "desc"]]
                });
            }
        }

        // Clicks Reports Datatable
        if ($('#links-data').get(0)) {

            var sortIndex = $('#links-data').find("th[data-key='created_at']")[0].cellIndex;
            if ($('#links-data').get(0)) {
                $('#links-data').DataTable({
                    order: [[sortIndex, "desc"]]
                });
            }
        }

        if ($('.kc-us-groups').get(0)) {
            $('.kc-us-groups').select2({
                placeholder: 'Select Groups',
                allowClear: true,
                dropdownAutoWidth: true,
                width: 500,
                multiple: true
            });
        }

        $('.kc-us-date-picker').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        // Social Share
        $(".share-btn").click(function (e) {
            $('.networks-5').not($(this).next(".networks-5")).each(function () {
                $(this).removeClass("active");
                $(this).hide();
            });

            $(this).next(".networks-5").show();
            $(this).next(".networks-5").toggleClass("active");
        });

        /**
         * Get URM Presets Data.
         *
         * @since 1.5.12
         */
        $("#kc-us-utm-preset-dropdown").change(function (e) {

            e.preventDefault();

            var selectedUTMPresetID = $(this).val();
            var security = $('#kc-us-security').val();

            if (0 == selectedUTMPresetID) {
                $('#utm_id').val('');
                $('#utm_source').val('');
                $('#utm_campaign').val('');
                $('#utm_medium').val('');
                $('#utm_term').val('');
                $('#utm_content').val('');
                return;
            }

            $.ajax({
                type: "post",
                dataType: "json",
                context: this,
                url: ajaxurl,
                data: {
                    action: 'us_handle_request',
                    cmd: "get_utm_presets",
                    utm_preset_id: selectedUTMPresetID,
                    security: security,
                },
                success: function (response) {
                    if (response.status === "success") {
                        var utm_params = response.data;

                        if (utm_params.hasOwnProperty('utm_source')) {
                            $('#utm_id').val(utm_params.utm_id);
                            $('#utm_source').val(utm_params.utm_source);
                            $('#utm_campaign').val(utm_params.utm_campaign);
                            $('#utm_medium').val(utm_params.utm_medium);
                            $('#utm_term').val(utm_params.utm_term);
                            $('#utm_content').val(utm_params.utm_content);
                        }

                    } else {
                        var html = 'Something went wrong while creating short link';
                    }
                },

                error: function (err) {
                    var html = 'Something went wrong while creating short link';
                }
            });
        });
    });
})(jQuery);

// Confirm Deletion
function confirmDelete() {
    return confirm('Are you sure you want to delete short link?');
}

// Confirm reseting of stats
function confirmReset() {
    return confirm('Are you sure you want to reset statistics of short link?');
}
