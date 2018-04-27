define(['jquery', 'TYPO3/CMS/Guard7/Guard7Tools'], function ($, Guard7Tools) {

    $('#createkey button').click(function(e) {
        e.stopPropagation();
        e.preventDefault();
        var depth = $(this).val();
        var password = $('#createkey input[name="password"]').val();
        if (!password || password.length < 1) {
            password = null;
        }
        //console.log($('#loading'));
        $('#loading').removeClass('off');
        Guard7Tools.createPrivateKey(password, depth)
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
