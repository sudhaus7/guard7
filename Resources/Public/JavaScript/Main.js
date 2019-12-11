define(['jquery', 'TYPO3/CMS/Guard7/Guard7Tools'], function ($, Guard7Tools) {
console.log('loaded');
    const unlockData = function () {
        if (Guard7Tools.hasPrivateKey()) {
            var privkey = Guard7Tools.getPrivateKey();
            sudhaus7guard7data.forEach(function (e) {
                //console.log('tick', e.fieldname);

                switch (e.method) {
                    case 'val':
                        if (parseInt($(e.identifier).data('locked')) === 1) {
                            Guard7Tools.decode(privkey, e, function (data) {
                                $(e.identifier).val(data).prop('disabled', false);
                                $(e.identifier).removeProp('disabled');
                                $(e.identifier).attr('placeholder', '').data('locked', 0).change();
                                window.setTimeout(function () {
                                    $(e.identifier).parents('.has-change').removeClass('has-change');
                                }, 100);

                            });
                        }
                        break;
                    case 'label':
                        if (parseInt($(e.identifier).data('locked')) === 1) {
                            var arr = e.secretdata.split('|');
                            for (var i = 0, l = arr.length; i < l; i++) {
                                Guard7Tools.decode(privkey, {'secretdata': arr[i]}, function (data) {
                                    arr[i] = data;
                                });
                            }
                            $(e.identifier).text(arr.join(', ')).data('locked', 0);
                        }
                        break;
                    default:
                        break;
                }
            });
        }

    };

    const lockData = function () {
        sudhaus7guard7data.forEach(function (data) {
            switch (data.method) {
                case 'val':
                    $(data.identifier).val('').attr('placeholder', '🔒 Bitte Privaten Schlüssel angeben').prop('disabled', true).data('locked', 1).change();
                    window.setTimeout(function () {
                        $(data.identifier).parents('.has-error').removeClass('has-error');
                    }, 500);
                    break;
                case 'label':
                    const count = data.secretdata.split('|').length;
                    var txt = [];
                    for (var i = 0; i < count; i++) {
                        txt.push('🔒');
                    }
                    $(data.identifier).text(txt.join(',')).data('locked', 1);
                    break;
                default:
                    break;
            }
        });
    };

    const initFields = function () {

        for (var i = 0, l = sudhaus7guard7data.length; i < l; i++) {
            var data = sudhaus7guard7data[i];
            switch (data.method) {
                case 'val':
                    if (parseInt($(data.identifier).data('locked')) === 0 || isNaN($(data.identifier).data('locked'))) {
                        $(data.identifier).val('').attr('placeholder', '🔒 Bitte Privaten Schlüssel angeben').prop('disabled', 'disabled').data('locked', 1);
                        window.setTimeout(function () {
                            $(data.identifier).parents('.has-error').removeClass('has-error');
                        }, 500);
                    }
                    break;
                case 'label':
                    if (parseInt($(data.identifier).data('locked')) === 0 || isNaN($(data.identifier).data('locked'))) {
                        var txt = $(data.identifier).text();
                        $(data.identifier).text(txt.replace(/&#128274;/g, '🔒')).data('locked', 1);
                    }
                    break;
                default:
                    break;
            }
        }

    };

    var handleIrreEvent = function () {
        if (inline.isLoading) {
            window.setTimeout(handleIrreEvent, 100);
        } else {
            initFields();
            if (Guard7Tools.hasPrivateKey()) {
                unlockData();
            }
        }
    };

    var toggleEvent = function (event) {

        var $triggerElement = TYPO3.jQuery(event.target);
        if ($triggerElement.parents('.t3js-formengine-irre-control').length == 1) {
            return;
        }
        handleIrreEvent();
        // console.log('xxx',inline.isLoading);
    };

    if (sudhaus7guard7data) {
        //console.log(sudhaus7guard7data);
        initFields();
        if (Guard7Tools.hasPrivateKey()) {
            unlockData();
        }
        $(function () {
            $(document).delegate('[data-toggle="formengine-inline"]', 'click', toggleEvent);
        });
    }

    top.TYPO3.jQuery('body').on('sudhaus7-guard7-privkey-activated', function () {
        //  console.log('pre unlock');
        unlockData();
        //  console.log('post unlock');
    });
    top.TYPO3.jQuery('body').on('sudhaus7-guard7-privkey-removed', function () {
        lockData();
    });

});
