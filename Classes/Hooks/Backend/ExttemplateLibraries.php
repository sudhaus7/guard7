<?php
declare(strict_types=1);

namespace SUDHAUS7\Guard7\Hooks\Backend;

use function function_exists;

/**
 * Class ExttemplateLibraries
 *
 * @package SUDHAUS7\Guard7\Hooks\Backend
 */
class ExttemplateLibraries
{
    public function render(array $parameter = [])
    {
        $out = sprintf('<select name="%1$s" id="em-%1$s">', $parameter['fieldName']);
        
        if (function_exists('openssl_decrypt')) {
            $out .= sprintf('<option value="%s" %s>%s</option>', 'Openssl', 'Openssl' === $parameter['fieldValue'] ? 'selected' : '', 'OpenSSL Library (ext-openssl)');
        }
        $out .= '</select>';
        return $out;
    }
}
