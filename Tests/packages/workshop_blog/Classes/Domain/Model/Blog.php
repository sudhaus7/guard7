<?php


namespace WORKSHOP\WorkshopBlog\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Blog extends AbstractEntity
{
    
    /**
     * @var int
     */
    protected $tstamp;
    
    /**
     * @var string
     */
    protected $title;
    
    /**
     * @var \DateTime
     */
    protected $date;
    
    /**
     * @var string
     */
    protected $teaser;
    
    /**
     * @var string
     */
    protected $bodytext;
    
    
    /**
     * @return string|null
     */
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
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }
    
    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }
    
    /**
     * @return string|null
     */
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
    
    /**
     * @return string|null
     */
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
    
    /**
     * @return int
     */
    public function getTstamp(): int
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
