<?php

require_once 'WorkableErrors.php';
require_once 'Job.php';
require_once 'CandidateInfo.php';

class WorkableClient {
    private $available_phases = array(
        "published",
        "draft",
        "closed",
        "archived",
    );

    const WorkableAPIVersion = 2;

    function __construct($access_token, $subdomain) {
        $this->access_token = $access_token;
        $this->subdomain = $subdomain;
        $this->api_url = sprintf("https://www.workable.com/spi/v%s/accounts/%s", WorkableClient::WorkableAPIVersion, $subdomain);
    }

    function getJobs($phase = "published") {
        if (!in_array($phase, $this->available_phases)) {
            throw new NoSuchPhaseException("Phase: " . $phase);
        }

        $url = sprintf("jobs?phase=%s", $phase);
        $jobs_result = $this->getRequest($url);

        $jobs_list = array();
        foreach ($jobs_result->jobs as $job_info) {
            $job = new Job(
                $job_info->key,
                $job_info->title,
                $job_info->full_title,
                $job_info->code,
                $job_info->shortcode,
                $job_info->state,
                $job_info->department,
                $job_info->url,
                $job_info->application_url,
                $job_info->shortlink,
                $job_info->location->country,
                $job_info->location->country_code,
                $job_info->location->region,
                $job_info->location->region_code,
                $job_info->location->city,
                $job_info->location->zip_code,
                $job_info->location->telecommuting,
                $job_info->created_at
            );
            $jobs_list[] = $job;
        }
        return $jobs_list;
    }

    function getJobDetails($shortcode) {
        $url = sprintf("jobs/%s", $shortcode);
        $job_details_response = $this->getRequest($url);

        echo "job details:\n\n";
        print_r($job_details_response);

        $job = new Job(
            $job_details_response->key,
            $job_details_response->title,
            $job_details_response->full_title,
            $job_details_response->code,
            $job_details_response->shortcode,
            $job_details_response->state,
            $job_details_response->department,
            $job_details_response->url,
            $job_details_response->application_url,
            $job_details_response->shortlink,
            $job_details_response->location->country,
            $job_details_response->location->country_code,
            $job_details_response->location->region,
            $job_details_response->location->region_code,
            $job_details_response->location->city,
            $job_details_response->location->zip_code,
            $job_details_response->location->telecommuting,
            $job_details_response->created_at,
            $job_details_response->full_description,
            $job_details_response->description,
            $job_details_response->requirements,
            $job_details_response->benefits,
            $job_details_response->employment_type,
            $job_details_response->industry,
            $job_details_response->function,
            $job_details_response->experience,
            $job_details_response->education
        );

        return $job;
    }

    function getJobCandidates($shortcode) {
        $url = sprintf("jobs/%s/candidates", $shortcode);

        $candidates_response = $this->getRequest($url);

        $candidates = array();

        foreach ($candidates_response->candidates as $candidate_info) {
            $candidate = new CandidateInfo(
                $candidate_info->key,
                $candidate_info->name,
                $candidate_info->firstname,
                $candidate_info->lastname,
                $candidate_info->headline,
                $candidate_info->account->subdomain,
                $candidate_info->account->name,
                $candidate_info->job->shortcode,
                $candidate_info->job->title,
                $candidate_info->stage,
                $candidate_info->disqualified,
                $candidate_info->sourced,
                $candidate_info->profile_url,
                $candidate_info->address,
                $candidate_info->phone,
                $candidate_info->email,
                $candidate_info->outbound_mailbox,
                $candidate_info->domain,
                $candidate_info->created_at,
                $candidate_info->updated_at,
                $candidate_info->cover_letter,
                $candidate_info->summary,
                $candidate_info->education_entries,
                $candidate_info->experience_entries,
                $candidate_info->skills,
                $candidate_info->answers,
                $candidate_info->resume_url,
                $candidate_info->tags
            );

            $candidates[] = $candidate;
        }

        return $candidates;
    }

    function addCandidate($candidate, $shortcode) {
        // We need the initial "candidate" in json
        $candidate_wrapper = array(
            "candidate" => $candidate
        );

        $json_data = json_encode($candidate_wrapper);

        
        $url = sprintf("jobs/%s/candidates", $shortcode);

        $add_candidate_response = $this->postRequest($url, $json_data);

        if (array_key_exists("error", $add_candidate_response)) {
            throw new AddCandidateFailed($add_candidate_response['error']);
        }

        return $add_candidate_response;
    }
    

    function getRequest($url) {
        $full_url = $this->api_url . "/" . $url;

        $headers = array(
            "Content-Type: application/json",
            "Authorization:Bearer " . $this->access_token,
            "User-Agent: Workable PHP Client",
        );

        $curl = curl_init($full_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $curl_response = curl_exec($curl);

        echo "URL: " . $full_url;
        echo "JSON_DATA: \n\n";
        print_r($curl_response);

        $response = json_decode($curl_response);
        curl_close($curl);

        return $response;
    }

    function postRequest($url, $json_data) {
        $full_url = $this->api_url . "/" . $url;

        $headers = array(
            "Content-Type: application/json",
            'Content-Length: ' . strlen($json_data),
            "Authorization:Bearer " . $this->access_token,
            "User-Agent: Workable PHP Client",
        );

        $curl = curl_init($full_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response, true);
        curl_close($curl);

        return $response;
    }

}

?>
