define(['jquery','TYPO3/CMS/Datavault/DatavaultTools'], function($,DatavaultTools) {

    $('#createkey button').click(function(e) {
        e.stopPropagation();
        e.preventDefault();
        console.log($('#loading'));
        $('#loading').removeClass('off');
        DatavaultTools.createPrivateKey(null,2048)
        .then(function(keypair) {
            $('#createkey textarea[name="privatekey"]').val(keypair.privateKey);
            $('#createkey textarea[name="publickey"]').val(keypair.publicKey);
            $('#loading').addClass('off');
        })
        .catch(function (err) {

            $('#loading').addClass('off');
        });
    })

});
