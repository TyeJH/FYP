<?php

require_once '../fpdf.php';
require_once '../Domain/Student.php';
require_once '../DataAccess/StudentDA.php';
require_once '../DataAccess/ParticipantsDA.php';
require_once '../DataAccess/HelpersDA.php';
require_once '../DataAccess/SocietyEventDA.php';
require_once '../DataAccess/ScheduleDA.php';

class StudHistoryPDF extends FPDF {

    private $userID;

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
        $this->Cell(200, 5, 'Student History Report', 0, 0, 'C');
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
        $studentDA = new StudentDA();
        $student = $studentDA->retrieveStudentDetails($this->userID);
        $this->Cell(0, 5, 'Student ID: ' . $student['studID'], 0, 1, 'L');
        $this->Cell(0, 5, 'Name: ' . $student['studName'], 0, 1, 'L');
    }

    function headerTable() {
        $this->SetFont('Times', 'B', 12);
        $this->Ln();
        //Table header
        $this->Cell(10, 10, 'No', 1, 0, 'C');
        $this->Cell(30, 10, 'Event ID', 1, 0, 'C');
        $this->Cell(50, 10, 'Event Name', 1, 0, 'C');
        $this->Cell(50, 10, 'Date Attend', 1, 0, 'C');
        $this->Cell(50, 10, 'Participant/Helper', 1, 0, 'C');
        $this->Ln();
    }

    function getContent() {
        $this->SetFont('Times', '', 12);

        $pda = new ParticipantsDA();
        $hda = new HelpersDA();
        $part = $pda->retrievePartHistory($this->userID);
        $help = $hda->retrieveHelpHistory($this->userID);
        $seda = new SocietyEventDA();
        $sda = new ScheduleDA();
        $count = 1;
        if (!empty($part)) {
            foreach ($part as $partList) {
                $history = $sda->retrieveHistory($partList->eventID);
                $future = $sda->retrieveFuture($partList->eventID);
                if (!empty($history)) {
                    foreach ($history as $historyList) {
                        if (empty($future)) {
                            $joined = $sda->retrieveByScheduleID($partList->scheduleID);
                            $eName = $seda->retrieveByEventID($partList->eventID);
                            if (!empty($joined)) {
                                $jDate = date("d-M-Y", strtotime($joined->startDate));
                                if (!empty($eName)) {
                                    $this->Cell(10, 10, $count, 1, 0, 'C');
                                    $this->Cell(30, 10, $historyList->eventID, 1, 0, 'C');
                                    $this->Cell(50, 10, $eName->eventName, 1, 0, 'C');
                                    $this->Cell(50, 10, $jDate, 1, 0, 'C');
                                    $this->Cell(50, 10, 'Participants', 1, 0, 'C');
                                    $this->Ln();
                                    $count++;
                                }
                            }
                        } else {
                            foreach ($future as $futureList) {
                                if ($historyList->eventID != $futureList->eventID) {
                                    $joined = $sda->retrieveByScheduleID($partList->scheduleID);
                                    $eName = $seda->retrieveByEventID($partList->eventID);
                                    if (!empty($joined)) {
                                        $jDate = date("d-M-Y", strtotime($joined->startDate));
                                        if (!empty($eName)) {
                                            $this->Cell(10, 10, $count, 1, 0, 'C');
                                            $this->Cell(30, 10, $historyList->eventID, 1, 0, 'C');
                                            $this->Cell(50, 10, $eName->eventName, 1, 0, 'C');
                                            $this->Cell(50, 10, $jDate, 1, 0, 'C');
                                            $this->Cell(50, 10, 'Participants', 1, 0, 'C');

                                            $this->Ln();
                                            $count++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($help)) {
            foreach ($help as $helpList) {
                $history = $sda->retrieveHistory($helpList->eventID);
                $future = $sda->retrieveFuture($helpList->eventID);
                if (!empty($history)) {
                    foreach ($history as $historyList) {
                        if (empty($future)) {
                            $eName = $seda->retrieveByEventID($helpList->eventID);
                            $sDate = date("d-M-Y", strtotime($historyList->startDate));
                            $eDate = date("d-M-Y", strtotime($historyList->endDate));
                            if (!empty($eName)) {
                                $this->Cell(19, 10, $count, 1, 0, 'C');
                                $this->Cell(30, 10, $historyList->eventID, 1, 0, 'C');
                                $this->Cell(50, 10, $eName->eventName, 1, 0, 'C');
                                $this->Cell(50, 10, $sDate . " - " . $eDate, 1, 0, 'C');
                                $this->Cell(50, 10, 'Helpers', 1, 0, 'C');
                                $this->Ln();
                                $count++;
                            }
                        } else {
                            foreach ($future as $futureList) {
                                if ($historyList->eventID != $futureList->eventID) {
                                    $eName = $seda->retrieveByEventID($helpList->eventID);
                                    $sDate = date("d-M-Y", strtotime($historyList->startDate));
                                    $eDate = date("d-M-Y", strtotime($historyList->endDate));
                                    if (!empty($eName)) {
                                        $this->Cell(10, 10, $count, 1, 0, 'C');
                                        $this->Cell(30, 10, $historyList->eventID, 1, 0, 'C');
                                        $this->Cell(50, 10, $eName->eventName, 1, 0, 'C');
                                        $this->Cell(50, 10, $sDate . " - " . $eDate, 1, 0, 'C');
                                        $this->Cell(50, 10, 'Helpers', 1, 0, 'C');
                                        $this->Ln();
                                        $count++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
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
        $this->Cell(190, 10, 'No Record Found', 0, 0, 'C');
    }

    function displayEndOfReport() {
        $this->Cell(0, 30, '------End Of Report------', 0, 0, 'C');
    }

}
