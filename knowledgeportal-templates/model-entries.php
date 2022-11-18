<?php 

//creating a class for entires for proper display
class KPEntry {

    //attributes
    private $title, $author, $content, $excerpt, $attachment_type, $attachment_link, $posted_date;

    //constructor
    function __construct($title, $author, $content, $excerpt, $attachment_type, $attachment_link, $posted_date) {
        $this->title = $title;
        $this->author = $author;
        $this->content = $content;
        $this->excerpt = $excerpt;
        $this->attachment_type = $attachment_type;
        $this->attachment_link = $attachment_link;
        $this->posted_date = $posted_date;
    }

    //getters
    function get_title() {
        return $this->title;
    }
    function get_author() {
        return $this->author;
    }
    function get_content() {
        return $this->content;
    }
    function get_excerpt() {
        return $this->excerpt;
    }
    function get_attachment_type() {
        return $this->attachment_type;
    }
    function get_attachment_link() {
        return $this->attachment_link;
    }
    function get_posted_date() {
        return $this->posted_date;
    }
    
}
?>