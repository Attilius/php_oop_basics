<?php


class Photo
{
    public string $id;
    public string $title;
    public string $thumbnail;
    public string $url;

    public function __construct(string $id, string $title, string $thumbnail, string $url)
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