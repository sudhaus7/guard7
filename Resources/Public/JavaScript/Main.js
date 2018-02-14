define(['jquery','TYPO3/CMS/Datavault/DatavaultTools'], function($,DatavaultTools) {



    var unlockData = function () {
        if(DatavaultTools.hasPrivateKey()) {
            var privkey = DatavaultTools.getPrivateKey();
            sudhaus7datavaultdata.forEach(function (e) {
                console.log('tick', e.fieldname);
                DatavaultTools.decode(privkey, e, function (data) {

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
        sudhaus7datavaultdata.forEach(function(e) {
            var name = 'data['+e.tablename+']['+e.tableuid+']['+e.fieldname+']';
            $('[data-formengine-input-name="'+name+'"]').val('').prop('disabled',true);
        });
    };

    if (sudhaus7datavaultdata) {
        //console.log(sudhaus7datavaultdata);
        for (var i=0,l=sudhaus7datavaultdata.length;i<l;i++) {
            var e = sudhaus7datavaultdata[i];
            var name = 'data['+e.tablename+']['+e.tableuid+']['+e.fieldname+']';
            $('[data-formengine-input-name="'+name+'"]').val('').attr('placeholder','🔒 Bitte Privaten Schlüssel angeben').prop('disabled','disabled');
        }

        if (DatavaultTools.hasPrivateKey()) {
            unlockData();
        }
    }

    top.TYPO3.jQuery('body').on('sudhaus7-datavault-privkey-activated',function() {
        console.log('pre unlock');
        unlockData();
        console.log('post unlock');
    });
    top.TYPO3.jQuery('body').on('sudhaus7-datavault-privkey-removed',function() {
        lockData();
    });

});
