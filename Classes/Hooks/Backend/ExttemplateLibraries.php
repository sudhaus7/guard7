<?php

declare(strict_types=1);

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

/**
 * Class ExttemplateLibraries
 */
final class ExttemplateLibraries
{
    public function render(array $parameter = []): string
    {
        $out = sprintf('<select name="%1$s" id="em-%1$s">', $parameter['fieldName']);

        if (function_exists('openssl_decrypt')) {
            $out .= sprintf('<option value="%s" %s>%s</option>', 'Openssl', 'Openssl' === $parameter['fieldValue'] ? 'selected' : '', 'OpenSSL Library (ext-openssl)');
        }

        return $out . '</select>';
    }
}
