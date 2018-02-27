define(['jquery','TYPO3/CMS/Datavault/DatavaultTools'], function($,DatavaultTools) {

    var unlockData = function () {
        if (DatavaultTools.hasPrivateKey()) {
            if (sudhaus7datavaulttables && sudhaus7datavaulttables.length > 0) {

                var ajaxUrl = TYPO3.settings.ajaxUrls['DatavaultBackend::getListData'];



                sudhaus7datavaulttables.forEach(function (tablename) {

                    var uids=[];
                    $('table[data-table="' + tablename + '"] tr[data-uid]').each(function(i,tr) {
                        if ($(tr).data('uid')) {
                            uids.push($(tr).data('uid'));
                        }
                    });
                    if (uids.length > 0) {
                        $.getJSON(ajaxUrl, {'table': tablename,'uids':uids}, function (sudhaus7datavaultdata) {
                            var privkey = DatavaultTools.getPrivateKey();
                            sudhaus7datavaultdata.forEach(function (e) {
                                DatavaultTools.decode(privkey, e, function (data) {
                                    $('table[data-table="' + e.tablename + '"] tr[data-uid="' + e.tableuid + '"] td.col-title span').attr('title', data).text(data);
                                });
                            });
                        });
                    }
                });



            }
        }
    };

    var lockData = function () {
        sudhaus7datavaulttables.forEach(function(e) {
            $('table[data-table="'+e+'"] tr[data-uid] td.col-title span').attr('title',"🔒").text("🔒");
        });
    };

    if (sudhaus7datavaulttables) {
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
