<?php


class Resume {
    public $name;
    public $data;

    function __construct($name, $data) {
        $this->name = $name;
        $this->data = $data;
    }
}

class EducationEntry {
    public $school;
    public $field_of_study;
    public $degree;
    public $start_date;
    public $end_date;

    function __construct($school, $field_of_study, $degree, $start_date, $end_date) {
        $this->school = $school;
        $this->field_of_study = $field_of_study;
        $this->degree = $degree;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
}

class ExperienceEntry {
    public $company;
    public $industry;
    public $title;
    public $summary;
    public $start_date;
    public $end_date;
    public $current;

    function __construct($company, $industry, $title, $summary, $start_date, $end_date, 
            $current) {
        $this->company = $company;
        $this->industry = $industry;
        $this->title = $title;
        $this->summary = $summary;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->current = $current;
    }
}

class Answer {
    public $question_key;
    public $body;

    function __construct($question_key, $body) {
        $this->question_key = $question_key;
        $this->body = $body;
    }
}

class SocialProfile {
    public $type;
    public $username;
    public $url;

    function __construct($type, $username, $url) {
        $this->type = $type;
        $this->username = $username;
        $this->url = $url;
    }
}

class Candidate {
    public $firstname;
    public $lastname;
    public $name;
    public $email;
    public $headline;
    public $summary;
    public $address;
    public $phone;
    public $notes;
    public $resume; // Single Resume object
    public $cover_letter;
    public $image_url;
    public $recruiter_key;
    public $education_entries; // Array of EducationEntry
    public $experience_entries; // Array of ExperienceEntry
    public $answers; // Array of Answer
    public $skills; // Array of strings
    public $social_profiles; // Array of SocialProfile

    function __construct($firstname, $lastname, $name, $email, $headline = '', $summary = '', 
        $address = '', $phone = '', $notes = '', $resume = '', $cover_letter = '', $image_url = '', 
        $recruiter_key = '', $education_entries = '', $experience_entries = '', $answers = '', 
        $skills = '', $social_profiles = '') {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->name = $name;
        $this->email = $email;
    }
}

?>
