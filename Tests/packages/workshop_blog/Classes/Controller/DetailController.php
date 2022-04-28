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

namespace WORKSHOP\WorkshopBlog\Controller;

use DateTime;
use function strip_tags;
use Sudhaus7\Guard7\Tools\FrontendUserPublicKeySingleton;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use WORKSHOP\WorkshopBlog\Domain\Model\Blog;
use WORKSHOP\WorkshopBlog\Domain\Model\Comment;
use WORKSHOP\WorkshopBlog\Domain\Repository\BlogRepository;
use WORKSHOP\WorkshopBlog\Domain\Repository\CommentRepository;

final class DetailController extends ActionController
{
    private ?BlogRepository $blogRepository = null;

    private ?CommentRepository $commentRepository = null;

    public function injectBlogRepository(BlogRepository $blogRepository): void
    {
        $this->blogRepository = $blogRepository;
    }

    public function injectCommentRepository(CommentRepository $commentRepository): void
    {
        $this->commentRepository = $commentRepository;
    }

    public function detailAction(Blog $blog): void
    {
        $newcomment = new Comment();

        $this->view->assignMultiple([
           'blog'=>$blog,
           'comments'=>$this->commentRepository->findByBlog($blog),
           'newcomment'=>$newcomment,
        ]);
    }

    /**
     * @param Comment $comment
     * @throws StopActionException
     * @throws UnsupportedRequestTypeException
     * @throws IllegalObjectTypeException
     */
    public function savecommentAction(Comment $comment): void
    {
        $comment->setDate(new DateTime());
        $comment->setComment(strip_tags($comment->getComment()));
        $comment->setCommentor(strip_tags($comment->getCommentor()));

        if (GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('frontend.user', 'isLoggedIn')) {
            $encodeStorage = GeneralUtility::makeInstance(FrontendUserPublicKeySingleton::class);
            $encodeStorage->add($comment);
        }

        $this->commentRepository->add($comment);
        $this->redirect('detail', null, null, ['blog'=>$comment->getBlog()]);
    }
}
