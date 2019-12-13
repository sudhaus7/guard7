<?php


namespace WORKSHOP\WorkshopBlog\Domain\Model;

use SUDHAUS7\Guard7\Interfaces\Guard7Interface;
use SUDHAUS7\Guard7\Traits\Guard7Trait;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Comment extends AbstractEntity implements Guard7Interface
{
    use Guard7Trait;
    
    /**
     * @var int
     */
    protected $tstamp;
    
    
    /**
     * @var string
     */
    protected $commentor;
    
    /**
     * @var string
     */
    protected $comment;
    
    /**
     * @var \DateTime
     */
    protected $date;
    
    /**
     * @var \WORKSHOP\WorkshopBlog\Domain\Model\Blog
     */
    protected $blog;
    
    /**
     * @return string
     */
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
    
    /**
     * @return string
     */
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
    
    /**
     * @return Blog
     */
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
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }
    

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
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
