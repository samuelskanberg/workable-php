<?php

require_once 'WorkableClient.php';
require_once 'CandidateInfo.php';
require_once 'Candidate.php';

class WorkableClientTest extends PHPUnit_Framework_TestCase {

    function setUp() {
        $config_file = "config.ini";

        $ini_array = parse_ini_file($config_file);
        $this->access_token = $ini_array["access_token"];
        $this->subdomain = $ini_array["subdomain"];
        $this->job1_shortcode = $ini_array["job1_shortcode"];
        $this->job_with_custom_questions_shortcode = $ini_array["job_with_custom_questions_shortcode"];
    }

    function testConstructor() {
        $access_token = 'abc123';
        $subdomain = "my-sub-domain";
        $client = new WorkableClient($access_token, $subdomain);
        $this->assertTrue($client->access_token == $access_token);
        $this->assertTrue($client->subdomain == $subdomain);
    }

    function testConstructorWithConfigFile() {
        $client = new WorkableClient($this->access_token, $this->subdomain);
        $this->assertTrue($client->access_token != null);
        $this->assertTrue($client->subdomain != null);
    }


    function testGetPublishedJobs() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $jobs = $client->getJobs();
        $this->assertTrue($jobs != null);
    }

    function testGetJobsWithBadPhase() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $this->setExpectedException(
            'NoSuchPhaseException', 'dsa'
        );
        $jobs = $client->getJobs("dsa");
    }

    function testGetJobDetails() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $shortcode = $this->job1_shortcode;
        $jobs = $client->getJobDetails($shortcode);
        $this->assertTrue($jobs != null);
    }

    function testGetJobDetailsWithCustomQuestions() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $shortcode = $this->job_with_custom_questions_shortcode;
        $jobs = $client->getJobDetails($shortcode);
        $this->assertTrue($jobs != null);
    }

    function testGetJobCandidates() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $shortcode = $this->job1_shortcode;
        $candidates = $client->getJobCandidates($shortcode);

        $this->assertTrue($candidates != null);
    }

    function testCreateCandidateObject() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $shortcode = $this->job1_shortcode;
        $candidate = new Candidate(
            '',
            '',
            'John Doe',
            'john.doe@samplemail.com'
        );

        $candidate_wrapper = array("candidate" => $candidate);
    }

    function testAddCandidate() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $shortcode = $this->job1_shortcode;
        $candidate = new Candidate(
            'Karl',
            'Davidsson',
            '',
            'karl.davidsson@foo.com' 
        );

        $candidate_wrapper = array("candidate" => $candidate);

        $result = $client->addCandidate($candidate, $shortcode);

        $this->assertEquals($result['status'], "created");
    }

    function testAddCandidateWithMoreVariables() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $shortcode = $this->job1_shortcode;
        $candidate = new Candidate(
            'Lissy',
            'Smith',
            '',
            'liss.smith@foo.com' 
        );

        $candidate->headline = 'A super awesome developer';
        $candidate->phone = '0702453788';
        $candidate->address = 'Stenens gata 32';
        $candidate->education_entries = array(
            new EducationEntry(
               'Lunds Tekniska Högsskola',
                'Computer science',
                'Civilingenjörsexamen',
                '2005-08-01',
                '2012-01-01'
            )
        );
        $candidate->experience_entries = array(
            new ExperienceEntry(
                'Ericsson',
                'Telecom',
                'Tester',
                'I worked for some time doing testing',
                '2010-04-03',
                '2011-01-01',
                false
            ),
            new ExperienceEntry(
                'Google',
                'IT',
                'Web developer',
                'I worked for some time doing HTML5 stuff',
                '2011-01-05',
                '',
                true
            )
        );
        $candidate->summary = 'I am a person who likes working and all that interesting stuff';

        $result = $client->addCandidate($candidate, $shortcode);

        $this->assertEquals($result['status'], "created");
    }

    //function testAddCandidateWithCustomQuestions() {
    //    $client = new WorkableClient($this->access_token, $this->subdomain);

    //    $shortcode = 'F25F3C61E6';
    //    $candidate = new Candidate(
    //        'Ali',
    //        'Smith',
    //        '',
    //        'ali.smith@foo.com' 
    //    );

    //    $result = $client->addCandidate($candidate, $shortcode);

    //    $this->assertEquals($result['status'], "created");
    //}

    function testAddCandidateWithMoreVariablesAndUploads() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $shortcode = $this->job1_shortcode;
        $candidate = new Candidate(
            'Sebastian',
            'Smith',
            '',
            'amy.smith@foo.com' 
        );

        $file_data = file_get_contents("test/very-short-cv.pdf");

        if (!$file_data) {
            $this->fail("Could not read file data");
        }

        $base64data = base64_encode($file_data);

        $candidate->resume = new Resume(
            'Super-cv.pdf',
            $base64data
        );

        $result = $client->addCandidate($candidate, $shortcode);

        $this->assertEquals($result['status'], "created");
    }

    function testAddBadCandidate() {
        $client = new WorkableClient($this->access_token, $this->subdomain);

        $shortcode = $this->job1_shortcode;
        $candidate = new Candidate(
            'Karl',
            'Davidsson',
            '',
            '' // Empty email - will faild
        );

        $candidate_wrapper = array("candidate" => $candidate);

        $this->setExpectedException(
            'AddCandidateFailed', "Validation failed: Email can't be blank, Email is invalid"
        );

        $result = $client->addCandidate($candidate, $shortcode);
    }

}


?>
