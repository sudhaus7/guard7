define(['jquery','TYPO3/CMS/Datavault/DatavaultTools'], function($,DatavaultTools) {

    var unlockData = function () {
        if(DatavaultTools.hasPrivateKey()) {
            var privkey = DatavaultTools.getPrivateKey();
            sudhaus7datavaultdata.forEach(function (e) {
                DatavaultTools.decode(privkey, e, function (data) {
                    $('table[data-table="' + e.tablename + '"] tr[data-uid="' + e.tableuid + '"] td.col-title span').attr('title', data).text(data);
                });
            });
        }
    };

    var lockData = function () {
        sudhaus7datavaultdata.forEach(function(e) {
            $('table[data-table="'+e.tablename+'"] tr[data-uid="'+e.tableuid+'"] td.col-title span').attr('title',"🔒").text("🔒");
        });
    };

    if (sudhaus7datavaultdata) {
        if (DatavaultTools.hasPrivateKey()) {
            unlockData();
        }
    }

    top.TYPO3.jQuery('body').on('sudhaus7-datavault-privkey-activated',function() {
        unlockData();
    });
    top.TYPO3.jQuery('body').on('sudhaus7-datavault-privkey-removed',function() {
        lockData();
    });

});
