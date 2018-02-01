define(['jquery','TYPO3/CMS/Datavault/Cryptojs','TYPO3/CMS/Datavault/Forge','TYPO3/CMS/Backend/Modal'], function($,CryptoJS,forge,Modal) {


    var getCheckSum = function(key) {
        var a = key.trim().split("\n");
        var active = false;
        var data = '';
        a.forEach(function(e) {

            if (active && (e.trim()=='-----END PUBLIC KEY-----' || e.trim()=='-----END PRIVATE KEY-----' || e.trim()=='-----END ENCRYPTED PRIVATE KEY-----')) {
                active = false;
            }
            if (active) {
                data = data+e.trim();
            }
            if (!active && (e.trim()=='-----BEGIN PUBLIC KEY-----' || e.trim()=='-----BEGIN PRIVATE KEY-----' || e.trim()=='-----END ENCRYPTED PRIVATE KEY-----')) {
                active = true;
            }
        });
        return  CryptoJS.SHA1(data).toString(CryptoJS.enc.UtF8);

    };


    var keyconfig = {
        init: false,
        privatekey:null,
        publicKey:null,
        publicPem: null,
        checksumpubkey: null
    };


    var getkeyconfig = function(privkey) {

        if (!keyconfig.init) {
            try {
                keyconfig.privateKey = forge.pki.privateKeyFromPem(privkey);
            } catch (e) {
                while (!keyconfig.privateKey) {
                    var password = prompt('Passwort des Privaten Schlüssels?');
                    keyconfig.privateKey = forge.pki.decryptRsaPrivateKey(privkey, password);
                }
            }
            keyconfig.publicKey = forge.pki.setRsaPublicKey(keyconfig.privateKey.n, keyconfig.privateKey.e);
            keyconfig.publicPem = forge.pki.publicKeyToPem(keyconfig.publicKey);
            keyconfig.checksumpubkey = getCheckSum(keyconfig.publicPem);
            keyconfig.init = true;
        }


    };



    var decode = function(privkey,row,callback) {
        callback = callback || function(){};


        getkeyconfig(privkey);

        if (!keyconfig.init) return;

        var msg = row.secretdata;

        var msgconfig = msg.split(':');
        var method = msgconfig.shift();
        var b64iv = msgconfig.shift();
        var b64envkey = msgconfig.shift();
        var b64secret = msgconfig.shift();

        var iv = CryptoJS.enc.Base64.parse(b64iv);

        var envkeycoded = CryptoJS.enc.Base64.parse(b64envkey);
        var secret = CryptoJS.enc.Base64.parse(b64secret);
        var envkeyar = JSON.parse(envkeycoded.toString(CryptoJS.enc.Utf8));

        var envelope = envkeyar[keyconfig.checksumpubkey];
        //   console.log(publicPem,checksumpubkey,envkeyar);

        var runmethod = null;
        switch (method) {
            case 'RC4':
                runmethod='RC4';
                break;
            case 'DES':
                runmethod='DES';
                break;
            case 'AES128':
            case 'AES192':
            case 'AES256':
            case 'AES512':
                runmethod='AES';
                break;
        }


        if (runmethod && typeof CryptoJS[runmethod] == 'object' && envelope) {

            var theKey = keyconfig.privateKey.decrypt(forge.util.decode64(envelope), 'RSAES-PKCS1-V1_5');
            var decrypted = CryptoJS[runmethod].decrypt({
                ciphertext: secret
            }, CryptoJS.enc.Latin1.parse(theKey),{iv:iv});
            //console.log('post crypto'); return;
            callback( decrypted.toString(CryptoJS.enc.Utf8) );
            //document.querySelector('[name="output"]').value = decrypted.toString(CryptoJS.enc.Utf8);
        }
    };

    var unlockData = function () {
        var privkey = window.sessionStorage.getItem('privkey');
        sudhaus7datavaultdata.forEach(function(e) {
            decode(privkey,e,function(data) {

                //var name = 'data['+e.tablename+']['+e.tableuid+']['+e.fieldname+']';
              //  console.log(name,data,e,privkey);
              //  $('[data-formengine-input-name="'+name+'"]').val(data).prop('disabled',false);
              //  $('[data-formengine-input-name="'+name+'"]').removeProp('disabled');

                $('table[data-table="'+e.tablename+'"] tr[data-uid="'+e.tableuid+'"] td.col-title span').attr('title',data).text(data);

                console.log('tock',e.fieldname);
            });
        });
    };

    var lockData = function () {
        sudhaus7datavaultdata.forEach(function(e) {
            $('table[data-table="'+e.tablename+'"] tr[data-uid="'+e.tableuid+'"] td.col-title span').attr('title',"🔒").text("🔒");
        });
        keyconfig = {
            init: false,
            privatekey:null,
            publicKey:null,
            publicPem: null,
            checksumpubkey: null
        };
    };

    if (sudhaus7datavaultdata) {
        //console.log(sudhaus7datavaultdata);
        var privkey = window.sessionStorage.getItem('privkey');
        if (privkey) {
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
