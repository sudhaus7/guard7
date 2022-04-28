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

$EM_CONF[$_EXTKEY] = [
    'title' => '(Sudhaus7) Guard7',
    'description' => 'A TYPO3 extension for encrypting and decrypting data in frontend and backend, including public and private key management.',
    'category' => 'misc',
    'state' => 'stable',
    'author' => 'Frank Berger',
    'author_email' => 'fberger@sudhaus7.de',
    'author_company' => 'Sudhaus7 https://sudhaus7.de/',
    'version' => '8.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.999',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
