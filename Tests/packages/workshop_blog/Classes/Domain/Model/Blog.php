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
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class Blog extends AbstractEntity
{
    private ?int $tstamp = null;

    private ?string $title = null;

    /**
     * @var DateTime|DateTimeImmutable|null
     */
    private ?DateTimeInterface $date = null;

    private ?string $teaser = null;

    private ?string $bodytext = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return DateTime|DateTimeImmutable
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    public function getTeaser(): ?string
    {
        return $this->teaser;
    }

    /**
     * @param string $teaser
     */
    public function setTeaser(string $teaser): void
    {
        $this->teaser = $teaser;
    }

    public function getBodytext(): ?string
    {
        return $this->bodytext;
    }

    /**
     * @param string $bodytext
     */
    public function setBodytext(string $bodytext): void
    {
        $this->bodytext = $bodytext;
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
