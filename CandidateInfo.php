<?php


class CandidateInfo {
    public $key;
    public $name;
    public $firstname;
    public $lastname;
    public $headline;
    public $account_subdomain;
    public $account_name;
    public $job_shortcode;
    public $job_title;
    public $stage;
    public $disqualified;
    public $sourced;
    public $profile_url;
    public $address;
    public $phone;
    public $email;
    public $outbound_mailbox;
    public $domain;
    public $created_at;
    public $updated_at;
    public $cover_letter;
    public $summary;
    public $education_entries;
    public $experience_entries;
    public $skills;
    public $answers;
    public $resume_url;
    public $tags;

    public function __construct($key, $name, $firstname, $lastname, $headline,  
        $account_subdomain, $account_name, $job_shortcode, $job_title, $stage, 
        $disqualified, $sourced, $profile_url, $address, $phone, $email, $outbound_mailbox, 
        $domain, $created_at, $updated_at, $cover_letter, $summary, $education_entries, 
        $experience_entries, $skills, $answers, $resume_url, $tags) {

        $this->key = $key;
        $this->name = $name;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->headline = $headline;
        $this->account_subdomain = $account_subdomain;
        $this->account_name = $account_name;
        $this->job_shortcode = $job_shortcode;
        $this->job_title = $job_title;
        $this->stage = $stage;
        $this->disqualified = $disqualified;
        $this->sourced = $sourced;
        $this->profile_url = $profile_url;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
        $this->outbound_mailbox = $outbound_mailbox;
        $this->domain = $domain;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->cover_letter = $cover_letter;
        $this->summary = $summary;
        $this->education_entries = $education_entries;
        $this->experience_entries = $experience_entries;
        $this->skills = $skills;
        $this->answers = $answers;
        $this->resume_url = $resume_url;
        $this->tags = $tags;
    }
}


?>
