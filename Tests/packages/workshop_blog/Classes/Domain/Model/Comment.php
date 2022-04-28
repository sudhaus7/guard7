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

namespace WORKSHOP\WorkshopBlog\Domain\Model;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Sudhaus7\Guard7\Interfaces\Guard7Interface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class Comment extends AbstractEntity implements Guard7Interface
{
    private ?int $tstamp = null;

    private ?string $commentor = null;

    private ?string $comment = null;

    /**
     * @var DateTime|DateTimeImmutable|null
     */
    private ?DateTimeInterface $date = null;

    private ?Blog $blog = null;

    public function getCommentor(): ?string
    {
        return $this->commentor;
    }

    /**
     * @param string $commentor
     */
    public function setCommentor(string $commentor): void
    {
        $this->commentor = $commentor;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    /**
     * @param Blog $blog
     */
    public function setBlog(Blog $blog): void
    {
        $this->blog = $blog;
    }

    /**
     * @return DateTime|DateTimeImmutable
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTime|DateTimeImmutable $date
     */
    public function setDate(DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    public function getTstamp(): ?int
    {
        return $this->tstamp;
    }

    /**
     * @param int $tstamp
     */
    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
    }
}
