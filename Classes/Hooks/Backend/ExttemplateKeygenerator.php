<?php


namespace SUDHAUS7\Guard7\Hooks\Backend;

class ExttemplateKeygenerator
{
    
    /**
     * @var string The button id
     */
    public static $BTNID = 'guard7newkeybtn1593882265';
    /**
     * @var string The info block id
     */
    public static $INFOID = 'guard7info1593882265';
    
    public static $PASSID = 'guard7password593882265';
    
    public function render(array $parameter = [])
    {
        $field = sprintf('<input type="hidden" name="%s" value="%s"/>', $parameter['fieldName'], trim($parameter['fieldValue']));
    
        $info = 'NO PUBLIC KEY SET';
    
        if (!empty($parameter['fieldValue'])) {
            $info = sprintf('Public Master Key: <pre>%s</pre>', $parameter['fieldValue']);
        }
        
        $passwordfield = sprintf('<input style="width:330px" type="text" id="%s" placeholder="(Optional) Password for Private Key (recommended)"/>', self::$PASSID);
        $button = sprintf('<button id="%s">Generate a new key-pair</button>', self::$BTNID);
    
        $keysizeid = 'em-defaultkeysize';
        
        $script = "<script type=\"text/javascript\">
document.getElementById('".self::$BTNID."').addEventListener('click',function(event) {
event.preventDefault();
event.stopPropagation();

let payload = {
    password: null,
    size: document.getElementById('".$keysizeid."').value
};
if(document.getElementById('".self::$PASSID."').value.length > 0) {
    payload.password = document.getElementById('".self::$PASSID."').value;
}
$.ajax({
    url: TYPO3.settings.ajaxUrls['guard7_create_new_keypair'],
    data: payload,
    method: 'POST',
    dataType: 'json',
    success: function(response) {
        $('input[name=\"".$parameter['fieldName']."\"]').val(response.public);
        $('#".self::$INFOID."').html('Public Master Key: <pre>'+response.public+'</pre><br/>Your new Private Master Key: <textarea style=\"width:100%;height:250px\">'+response.private+'</textarea><br/> <br/>This is the only time your Private Master Key will be visible here. Please copy it now and save it in a secure place. If you had set a password, please store the password as well in a different place. This Key is the only thing that will enable you to recover data if other keys are lost. Do not store this key on the server.<br/> <br/>The Key-pair will be activated on saving this configuration.<br/> <br/>');
    }
});
});
</script>";
    
    
        return $field.'<div id="'.self::$INFOID.'">'.$info.'</div><p>'.$passwordfield.' '.$button.'</p>'.$script;
    }
}
