<?php

require_once '../fpdf.php';
require_once '../Domain/Admin.php';
require_once '../Domain/Society.php';
include_once '../Domain/Transaction.php';
include_once '../DataAccess/SocietyDA.php';

class AccPDF extends FPDF {

    private $printid;

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
        $this->Cell(200, 5, 'Society Account Report', 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', '', 12);
        $this->Cell(200, 10, $_SESSION['result']->adminID, 0, 0, 'C');
        $this->Ln(20);
    }

    function footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function primaryTitle() {
        $this->SetFont('Times', 'B', 12);
        $eventDA = new SocietyEventDA();
        $event = $eventDA->retrieveByEventID($this->eventID);
        $this->Cell(0, 5, "Event ID: $event->eventID", 0, 1, 'L');
        $this->Cell(0, 5, "Event Name: $event->eventName", 0, 1, 'L');
    }

    function headerTable($attendanceStatus) {
        $this->SetFont('Times', 'B', 12);
        $this->Ln();
        //Table header
        $this->Cell(30, 10, 'Transaction ID', 1, 0, 'C');
        $this->Cell(30, 10, 'Transaction Date', 1, 0, 'C');
        $this->Cell(40, 10, 'Credit/Debit Amount (RM)', 1, 0, 'C');
        $this->Cell(50, 10, 'Purpose', 1, 0, 'C');
        $this->Ln();
    }

    function getContent($scheduleID, $attendanceStatus) {
        $this->SetFont('Times', '', 12);
        $participantsDA = new ParticipantsDA();
        $participantArray = $participantsDA->retrieveByScheduleIdAndAttendanceStatus($scheduleID, $attendanceStatus);
        $studentDA = new StudentDA();
        $count = 0;
        if ($participantArray == null) {
            $this->Cell(150, 10, 'No record found.', 1, 1, 'C');
        } else {
            foreach ($participantArray as $participant) {
                $student = $studentDA->retrieveStudentDetails($participant->userID);
                $this->Cell(30, 10, $count + 1, 1, 0, 'C');
                $this->Cell(30, 10, $student['studID'], 1, 0, 'C');
                $this->Cell(40, 10, $student['studName'], 1, 0, 'C');
                $this->Cell(50, 10, $student['studEmail'], 1, 0, 'C');
                $this->Ln();
                $count++;
                $this->totalParticipantsPerSession++;
                $this->grandTotalParticipants++;
                if ($attendanceStatus == 'Attend') {
                    $this->totalAttendedPerSession++;
                    $this->grandTotalAttended++;
                } else {
                    $this->totalAbsentPerSession++;
                    $this->grandTotalAbsent++;
                }
            }
        }
    }

    function displayContent($scheduleID) {
        //Display attended participants
        $this->headerTable('Attended');
        $this->getContent($scheduleID, 'Attend');
    }

    function displayLine() {
        $this->Line(20, 45, 210 - 20, 45); // 20mm from each edge
    }

    function displayGrandSummry() {
        $this->Ln();
        if ($this->grandTotalParticipants != 0) {
            $this->SetFont('Times', 'BU', 12);
            $this->Cell(0, 10, "Overall Summary", 0, 1, 'L');
            $this->SetFont('Times', '', 12);
            $this->Cell(0, 5, "Grand Total Participants : $this->grandTotalParticipants", 0, 1, 'L');
            $attendRate = $this->grandTotalAttended / $this->grandTotalParticipants * 100;
            $absentRate = $this->grandTotalAbsent / $this->grandTotalParticipants * 100;
            $this->Cell(0, 5, "Grand Total Attended : $this->grandTotalAttended ($attendRate%)", 0, 1, 'L');
            $this->Cell(0, 5, "Grand Total Absent : $this->grandTotalAbsent ($absentRate%)", 0, 1, 'L');
        }
    }

    function displayNoRecordFound() {
        $this->Cell(0, 30, 'No Record Found', 0, 0, 'C');
    }

    function displayEndOfReport() {
        $this->Cell(0, 30, '------End Of Report------', 0, 0, 'C');
    }

}
