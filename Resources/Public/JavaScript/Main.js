define(['jquery', 'TYPO3/CMS/Guard7/Guard7Tools'], function ($, Guard7Tools) {



    var unlockData = function () {
        if (Guard7Tools.hasPrivateKey()) {
            var privkey = Guard7Tools.getPrivateKey();
            sudhaus7guard7data.forEach(function (e) {
                console.log('tick', e.fieldname);
                Guard7Tools.decode(privkey, e, function (data) {

                    var name = 'data[' + e.tablename + '][' + e.tableuid + '][' + e.fieldname + ']';
                    //  console.log(name,data,e,privkey);
                    $('[data-formengine-input-name="' + name + '"]').val(data).prop('disabled', false);
                    $('[data-formengine-input-name="' + name + '"]').removeProp('disabled');
                    console.log('tock', e.fieldname);
                });
            });
        }
    };

    var lockData = function () {
        sudhaus7guard7data.forEach(function (e) {
            var name = 'data['+e.tablename+']['+e.tableuid+']['+e.fieldname+']';
            $('[data-formengine-input-name="'+name+'"]').val('').prop('disabled',true);
        });
    };

    if (sudhaus7guard7data) {
        //console.log(sudhaus7guard7data);
        for (var i = 0, l = sudhaus7guard7data.length; i < l; i++) {
            var e = sudhaus7guard7data[i];
            var name = 'data['+e.tablename+']['+e.tableuid+']['+e.fieldname+']';
            $('[data-formengine-input-name="'+name+'"]').val('').attr('placeholder','🔒 Bitte Privaten Schlüssel angeben').prop('disabled','disabled');
        }

        if (Guard7Tools.hasPrivateKey()) {
            unlockData();
        }
    }

    top.TYPO3.jQuery('body').on('sudhaus7-guard7-privkey-activated', function () {
        console.log('pre unlock');
        unlockData();
        console.log('post unlock');
    });
    top.TYPO3.jQuery('body').on('sudhaus7-guard7-privkey-removed', function () {
        lockData();
    });

});
