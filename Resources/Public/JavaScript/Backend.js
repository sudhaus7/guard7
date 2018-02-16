define(['jquery','TYPO3/CMS/Datavault/DatavaultTools'], function($,DatavaultTools) {

    $('#createkey button').click(function(e) {
        e.stopPropagation();
        e.preventDefault();


        DatavaultTools.createPrivateKey(null,function(keypair) {
            $('#createkey textarea[name="privatekey"]').val(keypair.privateKey);
            $('#createkey textarea[name="publickey"]').val(keypair.publicKey);
        });
    })

});
