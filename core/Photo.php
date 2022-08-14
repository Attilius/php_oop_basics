<?php


class Photo
{
    public $id;
    public string $title;
    public $thumbnail;
    public $url;

    public function __construct($id, string $title, $thumbnail, $url)
    {
        $this->id = $id;
        $this->title = $title;
        $this->thumbnail = $thumbnail;
        $this->url = $url;

        if ($this->id == null){
            logMessage("WARN", "Id filed is null");
        }
        if ($this->title == null){
            logMessage("WARN", "Title filed is null");
        }
        if ($this->thumbnail == null){
            logMessage("WARN", "Thumbnail filed is null");
        }
        if ($this->url == null){
            logMessage("WARN", "Url filed is null");
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}