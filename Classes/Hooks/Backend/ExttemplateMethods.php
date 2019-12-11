<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 21.02.18
 * Time: 16:48
 */

namespace SUDHAUS7\Guard7\Hooks\Backend;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\ViewHelpers\Form\TypoScriptConstantsViewHelper;

class ExttemplateMethods
{
    /**
     * Tag builder instance
     *
     * @var \TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder
     */
    protected $tag = null;
    
    /**
     * constructor of this class
     */
    public function __construct()
    {
        $this->tag = GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\Core\\ViewHelper\\TagBuilder');
    }
    
    /**
     * render textarea for extConf
     *
     * @param array $parameter
     * @param TypoScriptConstantsViewHelper $parentObject
     * @return string
     */
    public function render(array $parameter = array(), TypoScriptConstantsViewHelper $parentObject)
    {
        $content = '<option value="">Please choose</option>';
        
        if (defined('SODIUM_LIBRARY_VERSION')) {
            $content .= '<optgroup label="Sodium">';
            $content .= '<option value="libsodium">Sodium '.SODIUM_LIBRARY_VERSION.'</option>';
            $content .= '</optgroup>';
        }
        
        if (\function_exists('openssl_get_cipher_methods')) {
            $content .= '<optgroup label="OpenSSL">';
            $list = openssl_get_cipher_methods(false);
            foreach ($list as $method) {
                $content .= sprintf('<option value="%1$s" %2$s>%1$s</option>', $method, $method == $parameter['fieldValue'] ? 'selected' : '');
            }
            $content .= '</optgroup>';
        }
        
       
 
        /*
        foreach ($list as $k => $v) {
            //$up = \strtoupper($v);
            if ($up !== $v) {
                unset($list[$k]);
            }
        }
        */
        
        
        
        $this->tag->setTagName('select');
        $this->tag->forceClosingTag(true);
        $this->tag->addAttribute('name', $parameter['fieldName']);
        $this->tag->addAttribute('id', 'em-' . $parameter['fieldName']);
        $this->tag->setContent($content);
        return $this->tag->render();
    }
}
