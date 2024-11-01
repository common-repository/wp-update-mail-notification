var aweosEmailRecipientHasChanged = false;

jQuery(function ($) {

    var sendTestEmailButton = $('.awun-send-test-email');

    sendTestEmailButton.off();
    sendTestEmailButton.click(function (e) {
        var self = $(this);
        var url = window.location.origin + '/wp-admin/admin-ajax.php'
        var data = {
            action: 'awun-send-test-email'
        };

        e.preventDefault();

        if (aweosEmailRecipientHasChanged) {
            alert('E-Mail Recipient has changed. \r\nPlease save your options before sending a test E-Mail. \r\nThank you.');
            return false;
        }

        self.html('Sending...');

        $.get(url, data, function (res) {
            self.html(res);
        });
    });

    $('.awun-color-picker').wpColorPicker();

    jQuery('.awun-email-recipients').change(function () {
        aweosEmailRecipientHasChanged = true;
    });

});

