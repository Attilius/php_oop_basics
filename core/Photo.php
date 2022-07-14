<?php

class Photo
{

    public $id;
    public $title;
    public $thumbnail;
    public $url;

    public function __construct($id, $title, $thumbnail, $url)
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

}