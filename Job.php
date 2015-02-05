<?php

class Job {
    // From jobs listing
    private $key;
    private $title;
    private $full_title;
    private $code;
    private $shortcode;
    private $state;
    private $department;
    private $url;
    private $application_url;
    private $shortlink;
    private $country;
    private $country_code;
    private $region;
    private $region_code;
    private $city;
    private $zip_code;
    private $telecommuting;
    private $created_at;

    // From job details
    private $full_description;
    private $description;
    private $requirements;
    private $benefits;
    private $employment_type;
    private $industry;
    private $function;
    private $experience;
    private $education;

    public function __construct($key, $title, $full_title, $code, $shortcode, $state, 
        $department, $url, $application_url, $shortlink, $country, $country_code, $region,
        $region_code, $city, $zip_code, $telecommuting, $created_at, 
        // For details
        $full_description = '', $description = '', $requirements = '', $benefits = '', $employment_type = '', $industry = '', $function = '', $experience = '', $education = '') { 

        $this->key = $key;
        $this->title = $title;
        $this->full_title = $full_title;
        $this->code = $code;
        $this->shortcode = $shortcode;
        $this->state = $state;
        $this->department = $department;
        $this->url = $url;
        $this->application_url = $application_url;
        $this->shortlink = $shortlink;
        $this->country = $country;
        $this->country_code = $country_code;
        $this->region = $region;
        $this->region_code = $region_code;
        $this->city = $city;
        $this->zip_code = $zip_code;
        $this->telecommuting = $telecommuting;
        $this->created_at = $created_at;

        // Detailed info
        $this->full_description = $full_description;
        $this->description = $description;
        $this->requirements = $requirements;
        $this->benefits = $benefits;
        $this->employment_type = $employment_type;
        $this->industry = $industry;
        $this->function = $function;
        $this->experience = $experience;
        $this->education = $education;
    }
}

?>
