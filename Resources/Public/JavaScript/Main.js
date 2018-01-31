define(['jquery','TYPO3/CMS/Datavault/Cryptojs','TYPO3/CMS/Datavault/Forge','TYPO3/CMS/Backend/Modal'], function($,CryptoJS,Forge,Modal) {
    //console.log(CryptoJS,Forge);

    //alert('x');


    if (sudhaus7datavaultdata) {
        //console.log(sudhaus7datavaultdata);
        sudhaus7datavaultdata.forEach(function(e) {
           var name = 'data['+e.tablename+']['+e.tableuid+']['+e.fieldname+']';
           $('[data-formengine-input-name="'+name+'"]').val('').attr('placeholder','🔒 Bitte Privaten Schlüssel angeben').prop('disabled',true);
        });

        var privkey = window.sessionStorage.getItem('privkey');
        if (!privkey) {
            //var key = prompt('Bitte Privaten Key eingeben');
        }
    }
    var configurationStatic = {

        content: 'Da Key bitte <strong>test</strong><textarea id="dakey">Test</textarea>',
        buttons: [
            {
                text: 'Save changes',
                name: 'save',

                icon: 'actions-document-save',
                active: true,
                btnClass: 'btn-primary',
                dataAttributes: {
                    action: 'save'
                },
                trigger: function() {
                    console.log($('#dakey').val());
                    //alert(document.getElementById('dakey').value);
                    Modal.currentModal.trigger('modal-dismiss');
                }
            }
        ]


    };
    Modal.advanced(configurationStatic);

});
