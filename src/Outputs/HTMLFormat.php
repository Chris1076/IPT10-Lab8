<?php

namespace App\Outputs;

use App\Outputs\ProfileFormatter;

class HTMLFormat implements ProfileFormatter
{
    private $response;

    public function setData($profile)
    {
        $output = "<h1>Profile of " . $profile->getFullName() . "</h1>";
        $output .= "<p>Email: " . $profile->getContactDetails()['email'] . "</p>";
        $output .= "<p>Phone: " . $profile->getContactDetails()['phone_number'] . "</p>";
        $output .= "<h2>Education</h2>";
        $output .= "<p>" . $profile->getEducation()['degree'] . " at " . $profile->getEducation()['university'] . "</p>";
        $output .= "<h2>Skills</h2>";
        $output .= "<p>" . implode(", ", $profile->getSkills()) . "</p>";
        $output .= "<h2>Experience</h2><ul>";

        foreach ($profile->getExperience() as $job) {
            $output .= "<li>" . $job['job_title'] . " at " . $job['company'] . " (" . $job['start_date'] . " to " . $job['end_date'] . ")</li>";
        }

        $output .= "</ul>";
        $output .= "<h2>Certifications</h2><ul>";
        foreach( $profile->getCertifications() as $certificates) {
            $output .= "<li>".$certificates["name"]."(".$certificates["date_earned"].")"."</li>";
        }
        $output .= "</ul>";
        $output .= "<h2>Extracurricular Activities</h2><ul>";
        foreach( $profile->getExtracurricularActivities() as $activities) {
            $output .=  "<li>".$activities["role"]." of ".
            $activities["organization"]." (".
            $activities["start_date"]." to ".
            $activities["end_date"].") ".
            $activities["description"]."</li>";
        }
        $output .= "</ul><h2>Languages</h2><ul>";
        foreach( $profile->getLanguages() as $language) {
            $output .=  "<li>".$language["language"]."--".$language["proficiency"]."</li>";
        }
        $output .= "</ul><h2>References</h2>";
        foreach( $profile->getReferences() as $refs) {
            $output .=  "<p>Name: ".$refs["name"]."<br>Position: ".
            $refs["position"]."<br>Company: ".
            $refs["company"]."<br>Email: ".
            $refs["email"]."<br>Phone: ".
            $refs["phone_number"]."</p>";
        }
        $this->response = $output;
    }

    public function render()
    {
        return $this->response;
    }
}
