<?php 

//creating a class for entires for proper display
class KPEntry {

    //attributes
    public $title, $author, $excerpt, $content, $attachment_type, $attachment_link, $posted_date;

    //constructor
    function __construct($title, $author, $excerpt, $content, $attachment_type, $attachment_link, $posted_date) {
        $this->title = $title;
        $this->author = $author;
        $this->excerpt = $content;
        $this->content = $content;
        $this->attachment_type = $attachment_type;
        $this->attachment_link = $attachment_link;
        $this->posted_date = $posted_date;
    }

    
}
?>