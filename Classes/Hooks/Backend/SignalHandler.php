<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 16:39
 */

namespace SUDHAUS7\Datavault\Hooks\Backend;


use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SignalHandler {


	/**
	 * @param EditDocumentController $cntrl
	 */
	public function EditDocumentInit($cntrl) {

		$mypagerenderer = GeneralUtility::makeInstance( PageRenderer::class );
		$mypagerenderer->editconf = $cntrl->editconf;
		$mypagerenderer->controller = $cntrl;

	}

}
