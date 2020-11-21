<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../fpdf.php';
require '../Domain/Society.php';
require '../Domain/SocietyEvent.php';
require '../DataAccess/SocietyEventDA.php';
require '../DataAccess/ParticipantsDA.php';
require '../DataAccess/ScheduleDA.php';
require '../DataAccess/StudentDA.php';

class AttendancePDF extends FPDF {

    private $eventID;
    private $scheduleID;
    private $totalParticipantsPerSession;
    private $totalAttendedPerSession;
    private $totalAbsentPerSession;
    private $grandTotalParticipants;
    private $grandTotalAttended;
    private $grandTotalAbsent;

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
        $this->Cell(200, 5, 'Attendance Report', 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', '', 12);
        $this->Cell(200, 10, $_SESSION['result']->societyName, 0, 0, 'C');
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

    function scheduleTitle($scheduleID) {
        $this->Ln();
        $this->SetFont('Times', 'B', 12);
        $scheduleDA = new ScheduleDA();
        $schedule = $scheduleDA->retrieveByScheduleID($scheduleID);
        //convert format to dd/mm/yyyy 2200
        $stFormat = $schedule->startDate . " " . $schedule->startTime;
        $etFormat = $schedule->endDate . " " . $schedule->endTime;
        $st = strtotime($stFormat);
        $et = strtotime($etFormat);
        //convert format to Thursday, 2020--Oct-01 4:00 PM
        $startDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($stFormat));
        $endDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($etFormat));
        $this->Cell(0, 5, "Schedule: $startDateTimeFormatted - $endDateTimeFormatted", 0, 1, 'L');
    }

    function headerTable($attendanceStatus) {
        $this->SetFont('Times', 'B', 12);
        if ($attendanceStatus == 'Attend') {
            $this->Cell(0, 10, 'Status: Attended', 0, 0, 'L');
        } else {
            $this->Cell(0, 10, 'Status: Absent', 0, 0, 'L');
        }
        $this->Ln();
        //Table header
        $this->Cell(30, 10, 'No.', 1, 0, 'C');
        $this->Cell(30, 10, 'Student ID', 1, 0, 'C');
        $this->Cell(40, 10, 'Name', 1, 0, 'C');
        $this->Cell(50, 10, 'Email', 1, 0, 'C');
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
        //each session reset to 0
        $this->totalParticipantsPerSession = 0;
        $this->totalAttendedPerSession = 0;
        $this->totalAbsentPerSession = 0;
        //Display attended participants
        $this->headerTable('Attended');
        $this->getContent($scheduleID, 'Attend');
        //Display absent participants
        $this->headerTable('Absent');
        $this->getContent($scheduleID, 'Absent');
    }

    function displayLine() {
        $this->Line(20, 45, 210 - 20, 45); // 20mm from each edge
    }

    function displaySummaryPerSession() {
        $this->Ln();
        if ($this->totalParticipantsPerSession != 0) {
            $this->SetFont('Times', 'B', 12);
            $this->Cell(0, 10, "Summary for this schedule", 0, 1, 'L');
            $this->SetFont('Times', '', 12);

            $this->Cell(0, 5, "Total Participants : $this->totalParticipantsPerSession", 0, 1, 'L');
            $attendRate = $this->totalAttendedPerSession / $this->totalParticipantsPerSession * 100;
            $absentRate = $this->totalAbsentPerSession / $this->totalParticipantsPerSession * 100;
            $this->Cell(0, 5, "Total Attended : $this->totalAttendedPerSession ($attendRate%)", 0, 1, 'L');
            $this->Cell(0, 5, "Total Absent : $this->totalAbsentPerSession ($absentRate%)", 0, 1, 'L');
        }
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
