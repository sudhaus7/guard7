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

namespace Sudhaus7\Guard7\Controller;

use TYPO3\CMS\Core\Utility\PathUtility;
use Sudhaus7\Guard7\Adapter\ConfigurationAdapter;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

final class ToolbarController implements ToolbarItemInterface
{

    /**
     * @var mixed[]
     */
    private const EXT_CONFIG = [];

    /**
     * @api
     */
    private IconFactory $iconFactory;

    /**
     * @var string
     */
    private const GUARD7 = 'guard7';

    public function __construct()
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $pageRenderer = $this->getPageRenderer();
        $configadapter = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        $inlinecode = '';
        if ($configadapter->config['usejavascriptdecodinginbackend']) {
            $inlinecode .= 'var sudhaus7guard7data_DISABLED = false;';
        } else {
            $inlinecode .= 'var sudhaus7guard7data_DISABLED = true;';
        }

        if ($configadapter->config['populatebeuserprivatekeytofrontend']) {
            $inlinecode .= 'var sudhaus7guard7data_privatekeytofrontend = true;';
        } else {
            $inlinecode .= 'var sudhaus7guard7data_privatekeytofrontend = false';
        }

        $pageRenderer->addJsInlineCode(
            __METHOD__,
            $inlinecode
        );
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Guard7/Toolbar');
        $pageRenderer->addCssFile('../' . PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath(self::GUARD7)) . 'Resources/Public/Css/styles.css');
    }

    /**
     * Returns current PageRenderer
     */
    private function getPageRenderer(): PageRenderer
    {
        return GeneralUtility::makeInstance(PageRenderer::class);
    }

    public function checkAccess(): bool
    {
        return true;
    }

    public function getItem(): string
    {
        $opendocsMenu = [];
        $opendocsMenu[] = '<span class="t3-icon fa fa-lock" title="Guard7"></span>';
        return implode(LF, $opendocsMenu);
    }

    public function hasDropDown(): bool
    {
        return true;
    }

    public function getDropDown(): string
    {
        $dropdown = [];

        $dropdown[] = '<ul class="dropdown-list">';

        $dropdown[] = '<li class="clearKey"><button>' . LocalizationUtility::translate('toolbar.deactivatekey', self::GUARD7) . '</button></li>';
        $dropdown[] = '<li class="newkey-elem"><textarea name="newkey"></textarea><br/><button>' . LocalizationUtility::translate('toolbar.activatekey', self::GUARD7) . '</button></li>';

        $dropdown[] = '</ul>';

        return implode(LF, $dropdown);
    }

    /**
     * @return mixed[]
     */
    public function getAdditionalAttributes(): array
    {
        return [];
    }

    public function getIndex(): int
    {
        return 5;
    }

    public function injectIconFactory(IconFactory $iconFactory): void
    {
        $this->iconFactory = $iconFactory;
    }
}
