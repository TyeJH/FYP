<?php

require_once '../fpdf.php';
include_once '../Domain/Society.php';

include_once '../DataAccess/SocietyDA.php';

class SocietyAccountHistoryPDF extends FPDF {

    private $societyID;

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            return true;
        } else {
            return false;
        }
    }

    public function &__get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return false;
        }
    }

    function header() {
        $this->Image('../image/tarcBeyondEducation.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(200, 5, 'Society Account History', 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', '', 12);
        $this->Ln(20);
    }

    function footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function primaryTitle() {

        date_default_timezone_set("Asia/Kuala_Lumpur");
        $dateTime = date('d M Y H:i:s');
        $this->Cell(0, 5, "Generated On: $dateTime", 0, 1, 'L');
        $this->SetFont('Times', 'B', 12);

        $societyDA = new SocietyDA();

        $society = $societyDA->login($this->societyID);
        $this->Cell(0, 5, "Society ID: $society->societyID", 0, 1, 'L');
        $this->Cell(0, 5, "Society Name: $society->societyName", 0, 1, 'L');
    }

    function headerTable() {
        $this->SetFont('Times', 'B', 12);
        $this->Ln();
        //Table header
        $this->Cell(10, 10, 'No', 1, 0, 'C');
        $this->Cell(30, 10, 'Transaction ID', 1, 0, 'C');
        $this->Cell(50, 10, 'Transaction Date', 1, 0, 'C');
        $this->Cell(55, 10, 'Credit/Debit Amount (RM)', 1, 0, 'C');
        $this->Cell(45, 10, 'Purpose', 1, 0, 'C');
        $this->Ln();
    }

    function getContent() {
        $this->SetFont('Times', '', 12);
        $a = new SocietyDA();
        $b = $a->getTrans($this->societyID);
        if (!empty($b)) {
            $count = 1;
            foreach ($b as $history) {
                $date = date('d-M-Y', strtotime($history->transDate));
                $this->Cell(10, 10, $count, 1, 0, 'C');
                $this->Cell(30, 10, $history->transID, 1, 0, 'C');
                $this->Cell(50, 10, $date, 1, 0, 'C');
                $this->Cell(55, 10, $history->amount, 1, 0, 'C');
                $this->Cell(45, 10, $history->purpose, 1, 0, 'C');
                $this->Ln();
                $count++;
            }
        } else {
            $this->displayNoRecordFound();
            $this->Ln();
        }
    }

    function displayContent() {
        $this->headerTable();
        $this->getContent();
    }

    function displayLine() {
        $this->Line(20, 45, 210 - 20, 45); // 20mm from each edge
    }

    function displayNoRecordFound() {
        $this->Cell(190, 10, 'No Record Found', 1, 0, 'C');
    }

    function displayEndOfReport() {
        $this->Cell(0, 30, '------End Of Report------', 0, 0, 'C');
    }

}
