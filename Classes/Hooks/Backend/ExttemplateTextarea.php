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

use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\ViewHelpers\Form\TypoScriptConstantsViewHelper;

final class ExttemplateTextarea
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
        $this->tag->setTagName('textarea');
        $this->tag->forceClosingTag(true);
        $this->tag->addAttribute('cols', 45);
        $this->tag->addAttribute('rows', 15);
        $this->tag->addAttribute('style', 'width:100%;');
        $this->tag->addAttribute('name', $parameter['fieldName']);
        $this->tag->addAttribute('id', 'em-' . $parameter['fieldName']);
        if ($parameter['fieldValue'] !== null) {
            $this->tag->setContent(trim($parameter['fieldValue']));
        }

        return $this->tag->render();
    }
}
