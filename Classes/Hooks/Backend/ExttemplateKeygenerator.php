<?php

/*
 * This file is part of the TYPO3 project.
 * (c) 2022 B-Factor GmbH
 *          Sudhaus7
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 * @copyright 2022 B-Factor GmbH https://b-factor.de/
 * @author Frank Berger <fberger@b-factor.de>
 */

namespace Sudhaus7\Guard7\Hooks\Backend;

final class ExttemplateKeygenerator
{

    /**
     * @var string The button id
     */
    public static $BTNID = 'guard7newkeybtn1593882265';

    /**
     * @var string The info block id
     */
    public static $INFOID = 'guard7info1593882265';

    public static string $PASSID = 'guard7password593882265';

    /**
     * @var string
     */
    private const FIELD_VALUE = 'fieldValue';

    /**
     * @var string
     */
    private const KEYSIZEID = 'em-defaultkeysize';

    public function render(array $parameter = []): string
    {
        $field = sprintf('<input type="hidden" name="%s" value="%s"/>', $parameter['fieldName'], trim($parameter[self::FIELD_VALUE]));

        $info = 'NO PUBLIC KEY SET';

        if (!empty($parameter[self::FIELD_VALUE])) {
            $info = sprintf('Public Master Key: <pre>%s</pre>', $parameter[self::FIELD_VALUE]);
        }

        $passwordfield = sprintf('<input style="width:330px" type="text" id="%s" placeholder="(Optional) Password for Private Key (recommended)"/>', self::$PASSID);
        $button = sprintf('<button id="%s">Generate a new key-pair</button>', self::$BTNID);

        $script = "<script type=\"text/javascript\">
document.getElementById('" . self::$BTNID . "').addEventListener('click',function(event) {
event.preventDefault();
event.stopPropagation();

let payload = {
    password: null,
    size: document.getElementById('" . self::KEYSIZEID . "').value
};
if(document.getElementById('" . self::$PASSID . "').value.length > 0) {
    payload.password = document.getElementById('" . self::$PASSID . "').value;
}
$.ajax({
    url: TYPO3.settings.ajaxUrls['guard7_create_new_keypair'],
    data: payload,
    method: 'POST',
    dataType: 'json',
    success: function(response) {
        $('input[name=\"" . $parameter['fieldName'] . "\"]').val(response.public);
        $('#" . self::$INFOID . "').html('Public Master Key: <pre>'+response.public+'</pre><br/>Your new Private Master Key: <textarea style=\"width:100%;height:250px\">'+response.private+'</textarea><br/> <br/>This is the only time your Private Master Key will be visible here. Please copy it now and save it in a secure place. If you had set a password, please store the password as well in a different place. This Key is the only thing that will enable you to recover data if other keys are lost. Do not store this key on the server.<br/> <br/>The Key-pair will be activated on saving this configuration.<br/> <br/>');
    }
});
});
</script>";

        return $field . '<div id="' . self::$INFOID . '">' . $info . '</div><p>' . $passwordfield . ' ' . $button . '</p>' . $script;
    }
}
