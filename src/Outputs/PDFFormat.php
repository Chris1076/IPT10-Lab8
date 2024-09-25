<?php

namespace App\Outputs;

use App\Outputs\ProfileFormatter;
use Fpdf\Fpdf;

class PDFFormat implements ProfileFormatter
{
    private $pdf;

    public function setData($profile)
    {
        $this->pdf = new Fpdf();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(0, 10, 'Profile of ' . $profile->getFullName(), 0, 1, 'C');

        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->Cell(0, 10, 'Email: ' . $profile->getContactDetails()['email'], 0, 1);
        $this->pdf->Cell(0, 10, 'Phone: ' . $profile->getContactDetails()['phone_number'], 0, 1);
        
        // Address
        $address = implode(", ", $profile->getContactDetails()['address']);
        $this->pdf->Cell(0, 10, 'Address: ' . $address, 0, 1);
        
        // Education
        $this->pdf->Cell(0, 10, 'Education: ' . $profile->getEducation()['degree'] . ' at ' . $profile->getEducation()['university'], 0, 1);
        
        // Skills
        $this->pdf->Cell(0, 10, 'Skills: ');
        $this->pdf->Ln();
        foreach ($profile->getSkills() as $skill) {
            $this->pdf->Cell(0, 10, '- ' . $skill, 0, 1);
        }

        // Experience
        $this->pdf->Cell(0, 10, 'Experience:', 0, 1);
        foreach ($profile->getExperience() as $job) {
            $this->pdf->Cell(0, 10, '- ' . $job['job_title'] . ' at ' . $job['company'] . ' (' . $job['start_date'] . ' to ' . $job['end_date'] . ')', 0, 1);
        }
        //Certifications
        $this->pdf->Cell(0, 10, 'Certifications:', 0, 1);
        foreach( $profile->getCertifications() as $certificates) {
            $this->pdf->Cell( 0, 10, "-".$certificates["name"]."(".$certificates["date_earned"].")",0,1);
        }
        //Extracurricular_activities
        $this->pdf->Cell(0, 10, 'Extracurricular Activities:', 0, 1);
        foreach( $profile->getExtracurricularActivities() as $activities) {
            $this->pdf->Cell(0, 10, "-Role: ".$activities["role"], 0, 1);
            $this->pdf->Cell(0, 10, "-Organization: ".$activities["organization"], 0, 1);
            $this->pdf->Cell(0, 10,"-Start Date: ".$activities["start_date"], 0 , 1);
            $this->pdf->Cell(0, 10,"-End Date: ".$activities["end_date"], 0, 1);
            $this->pdf->MultiCell(175, 10, "-Description: ".$activities["description"], 0 );
            $this->pdf->Ln();
        }
        //Languages
        $this->pdf->Cell(0, 10, 'Languages:', 0, 1);
        foreach( $profile->getLanguages() as $language) {
            $this->pdf->Cell(0, 10,  "-".$language["language"].": ".$language["proficiency"], 0, 1);
            
        }
        $this->pdf->Ln();
        //References
        $this->pdf->Cell(0, 10, 'References:', 0, 1);
        foreach( $profile->getReferences() as $refs) {
            $this->pdf->Cell(0, 10, "-Name: ".$refs["name"], 0, 1);
            $this->pdf->Cell(0, 10, "-Position: ".$refs["position"], 0, 1);
            $this->pdf->Cell(0, 10, "-Comapny: ".$refs["company"], 0, 1);
            $this->pdf->Cell(0, 10, "-Email: ".$refs["email"], 0, 1);
            $this->pdf->Cell(0, 10, "-Phone: ".$refs["phone_number"], 0, 1);
            $this->pdf->Ln();
        }
    }

    public function render()
    {
        // Output PDF to string (to save to file)
        return $this->pdf->Output();
    }
}
