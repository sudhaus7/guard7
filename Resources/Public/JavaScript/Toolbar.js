define(['jquery', 'TYPO3/CMS/Guard7/Guard7Tools'], function ($, Guard7Tools) {

    if (window.sessionStorage.getItem('privkey')) {
        $('#sudhaus7-guard7-controller-toolbarcontroller > a > span').removeClass('fa-lock').addClass('fa-unlock');
        $('#sudhaus7-guard7-controller-toolbarcontroller .clearKey').show();
        $('#sudhaus7-guard7-controller-toolbarcontroller .newkey-elem').hide();
    }

    $('#sudhaus7-guard7-controller-toolbarcontroller .newkey-elem button').on('click', function (ev) {
        ev.stopPropagation();
        ev.preventDefault();
        var key = $('#sudhaus7-guard7-controller-toolbarcontroller [name="newkey"]').val();
        if (key.length > 0) {
            Guard7Tools.setPrivateKey(key);
            //window.sessionStorage.setItem('privkey',key);
            $('#sudhaus7-guard7-controller-toolbarcontroller > a > span').removeClass('fa-lock').addClass('fa-unlock');
            $('#sudhaus7-guard7-controller-toolbarcontroller .clearKey').show();
            $('#sudhaus7-guard7-controller-toolbarcontroller .newkey-elem').hide();
            $('body').trigger('sudhaus7-guard7-privkey-activated');
            //$('#sudhaus7-guard7-controller-toolbarcontroller [name="newkey"]').val('');
        }

    });

    $('#sudhaus7-guard7-controller-toolbarcontroller .clearKey button').on('click', function (ev) {
        ev.stopPropagation();
        ev.preventDefault();
        if (Guard7Tools.hasPrivateKey()) {
            Guard7Tools.clearPrivateKey();
            $('#sudhaus7-guard7-controller-toolbarcontroller > a > span').removeClass('fa-unlock').addClass('fa-lock');
            $('#sudhaus7-guard7-controller-toolbarcontroller .clearKey').hide();
            $('#sudhaus7-guard7-controller-toolbarcontroller .newkey-elem').show();
            $('body').trigger('sudhaus7-guard7-privkey-removed');

        }
    });

});
