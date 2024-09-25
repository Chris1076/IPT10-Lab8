<?php

namespace App\Outputs;

use App\Outputs\ProfileFormatter;

class TextFormat implements ProfileFormatter
{
    private $response;

    public function setData($profile)
    {
        $output = "Full Name: " . $profile->getFullName() . PHP_EOL;
        $output .= "Email: " . $profile->getContactDetails()['email'] . PHP_EOL;
        $output .= "Phone: " . $profile->getContactDetails()['phone_number'] . PHP_EOL;
        $output .= "Address: " . implode(", ", $profile->getContactDetails()['address']) . PHP_EOL;
        $output .= "Education: " . $profile->getEducation()['degree'] . " at " . $profile->getEducation()['university'] . PHP_EOL;
        $output .= "Skills: " . implode(", ", $profile->getSkills()) . PHP_EOL;

        // Add experience, certifications, etc.
        $output .= "Experience:\n";
        foreach ($profile->getExperience() as $job) {
            $output .= "- " . $job['job_title'] . " at " . $job['company'] . " (" . $job['start_date'] . " to " . $job['end_date'] . ")\n";
        }
        $output .= "Certifications\n";
        foreach( $profile->getCertifications() as $certificates) {
            $output .= "- ".$certificates["name"]."(".$certificates["date_earned"].")\n";
        }
        $output .= "Extracurricular Activities\n";
        foreach( $profile->getExtracurricularActivities() as $activities) {
            $output .=  "- ".$activities["role"]." at ".
            $activities["organization"]." (".
            $activities["start_date"]." to ".
            $activities["end_date"].") ".
            $activities["description"]."\n";
        }
        $output .= "Languages\n";
        foreach( $profile->getLanguages() as $language) {
            $output .=  "- ".$language["language"].": ".$language["proficiency"]."\n";
        }
        $output .= "References\n";
        foreach( $profile->getReferences() as $refs) {
            $output .=  "Name: ".$refs["name"]."\nPosition: ".
            $refs["position"]."\nCompany: ".
            $refs["company"]."\nEmail: ".
            $refs["email"]."\nPhone: ".
            $refs["phone_number"]."\n\n";
        }
        $this->response = $output;
    }

    public function render()
    {
        header('Content-Type: text');
        return $this->response;
    }
}
