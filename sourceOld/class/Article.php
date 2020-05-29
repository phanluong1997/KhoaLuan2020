<?php
class Article
{
    // author
    private $author;

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    // title
    private $title;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
    //nam
    private $year;

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getYear()
    {
        return $this->year;
    }
    //tạp chí
    private $journal;

    public function setJournal($journal)
    {
        $this->journal = $journal;
    }

    public function getJournal()
    {
        return $this->journal;
    }


    public function __set($name, $value)
    {
        switch ($name)
        {
            case 'author':
                return $this->setAuthor($value);
            case 'title':
                return $this->setTitle($value);
            case 'year':
                return $this->setYear($value); 
            case 'journal':
                return $this->setJournal($value);

        }

    }

    public function __get($name)
    {
        switch ($name)
        {
            case 'author':
                return $this->getAuthor();
            case 'title':
                return $this->getTitle();
            
            case 'year':
                return $this->getJournal();
            case 'journal':
                return $this->getJournal();
        }
    }
}
?>
