define(['jquery', 'TYPO3/CMS/Guard7/Cryptojs', 'TYPO3/CMS/Guard7/Forge'], function ($, CryptoJS, forge) {

    var Guard7Tools = {};


    Guard7Tools.getCheckSum = function (key) {
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

    Guard7Tools.clearPrivateKey = function () {
        window.sessionStorage.removeItem('Guard7Privkey');
    };


    Guard7Tools.createPrivateKey = function (password, bytes) {
        bytes = bytes || 2048;
        return new Promise(function(resolve,reject){
            resolve = resolve || function(){};
            reject = reject || function(){};
            forge.pki.rsa.generateKeyPair(bytes,{
                    workerScript: '/typo3conf/ext/guard7/Resources/Public/JavaScript/src/node_modules/node-forge/dist/prime.worker.min.js'
            },
            function(err,keypair) {
                try {
                    //console.log('xx',keypair);
                    if (password) {
                        var tmp = forge.pki.encryptRsaPrivateKey(keypair.privateKey, password, {algorithm: 'AES256'});
                        keypair.privateKey = tmp;
                    }
                    resolve({
                        privateKey: forge.pki.privateKeyToPem(keypair.privateKey, 64),
                        publicKey: forge.pki.publicKeyToPem(keypair.publicKey, 64)
                    });
                } catch(e) {
                    reject(e);
                }
            });
        });
    };

    Guard7Tools.setPrivateKey = function (privkey) {
        var keyconfig = {
            init: false,
            privatekey:null,
            publicKey:null,
            publicPem: null,
            checksumpubkey: null
        };

        try {
            keyconfig.privateKey = forge.pki.privateKeyFromPem(privkey);
            keyconfig.privateKeypem = privkey;
        } catch (e) {
            while (!keyconfig.privateKey) {
                var password = prompt('Passwort des Privaten Schlüssels?');
                keyconfig.privateKey = forge.pki.decryptRsaPrivateKey(privkey, password);
                keyconfig.privateKeypem = forge.pki.privateKeyToPem(keyconfig.privateKey,64);
            }
        }
        keyconfig.publicKey = forge.pki.setRsaPublicKey(keyconfig.privateKey.n, keyconfig.privateKey.e);
        keyconfig.publicPem = forge.pki.publicKeyToPem(keyconfig.publicKey);
        keyconfig.checksumpubkey = Guard7Tools.getCheckSum(keyconfig.publicPem);
        keyconfig.init = true;
        window.sessionStorage.setItem('Guard7Privkey', JSON.stringify(keyconfig));
    };


    Guard7Tools.getPrivateKey = function () {
        var keyconfig = window.sessionStorage.getItem('Guard7Privkey');
        if (keyconfig) {

            var keyconfig = JSON.parse(keyconfig);
            keyconfig.privateKey = forge.pki.privateKeyFromPem( keyconfig.privateKeypem );
            return keyconfig;
        }
        return {init:false};
    };

    Guard7Tools.hasPrivateKey = function () {
        var keyconfig = window.sessionStorage.getItem('Guard7Privkey');
        if (keyconfig) {
            var privkey = JSON.parse(keyconfig);
            return privkey.init;
        }
        return false;
    };

    Guard7Tools.decode = function (privatekeyconfig, row, callback) {

        if (!privatekeyconfig.init) return;

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

        var envelope = envkeyar[privatekeyconfig.checksumpubkey];
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

            var theKey = privatekeyconfig.privateKey.decrypt(forge.util.decode64(envelope), 'RSAES-PKCS1-V1_5');
            var decrypted = CryptoJS[runmethod].decrypt({
                ciphertext: secret
            }, CryptoJS.enc.Latin1.parse(theKey),{iv:iv});
            delete theKey;
            callback( decrypted.toString(CryptoJS.enc.Utf8) );
        }
    };


    window.Guard7Tools = Guard7Tools;
    return Guard7Tools;

});
