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

use function function_exists;
use function strtolower;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\ViewHelpers\Form\TypoScriptConstantsViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

final class ExttemplateMethods
{
    /**
     * Tag builder instance
     */
    private TagBuilder $tag;

    /**
     * constructor of this class
     */
    public function __construct()
    {
        $this->tag = GeneralUtility::makeInstance(TagBuilder::class);
    }

    /**
     * render textarea for extConf
     *
     * @param TypoScriptConstantsViewHelper $parentObject
     */
    public function render(array $parameter = [], TypoScriptConstantsViewHelper $parentObject): string
    {
        $content = '<option value="">Please choose</option>';
        /* TODO: implemenet sodium support
        if (defined('SODIUM_LIBRARY_VERSION')) {
            $content .= '<optgroup label="Sodium">';
            $content .= '<option value="libsodium">Sodium '.SODIUM_LIBRARY_VERSION.'</option>';
            $content .= '</optgroup>';
        }
        */
        if (function_exists('openssl_get_cipher_methods')) {
            $content .= '<optgroup label="OpenSSL">';
            $availablelist = openssl_get_cipher_methods(true);
            if (PHP_MAJOR_VERSION < 7) {
                $list = ['RC4', 'DES'];
            } else {
                $list = ['RC4', 'AES128', 'AES192', 'AES256', 'AES512', 'DES']; //to ensure Javascript compatibility
            }

            foreach ($list as $method) {
                if (in_array(strtolower($method), $availablelist, true)) {
                    $content .= sprintf('<option value="%1$s" %2$s>%1$s</option>', $method, $method === $parameter['fieldValue'] ? 'selected' : '');
                }
            }

            $content .= '</optgroup>';
        }

        $this->tag->setTagName('select');
        $this->tag->forceClosingTag(true);
        $this->tag->addAttribute('name', $parameter['fieldName']);
        $this->tag->addAttribute('id', 'em-' . $parameter['fieldName']);
        $this->tag->setContent($content);
        return $this->tag->render();
    }
}
