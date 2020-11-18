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
session_start();
//For particular schedule.
if (isset($_POST['eventID']) && isset($_POST['scheduleID'])) {


    class PDF extends FPDF {

        private $totalParticipants;
        private $totalAttended;
        private $totalAbsent;

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

        function contentTitle() {
            $this->SetFont('Times', 'B', 12);
            $eventID = $_POST['eventID'];
            $eventDA = new SocietyEventDA();
            $event = $eventDA->retrieveByEventID($eventID);
            $this->Cell(20, 5, "Event ID: $event->eventID", 0, 1, 'C');
            $this->Cell(55, 5, "Event Name: $event->eventName", 0, 1, 'C');
            $scheduleID = $_POST['scheduleID'];
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
            $this->Cell(120, 5, "Schedule: $startDateTimeFormatted - $endDateTimeFormatted", 0, 1, 'C');
        }

        function headerTable($attendanceStatus) {
            $this->SetFont('Times', 'B', 12);
            if ($attendanceStatus == 'Attended') {
                $this->Cell(29, 10, 'Status: Attended', 0, 0, 'C');
            } else {
                $this->Cell(27, 10, 'Status: Absent', 0, 0, 'C');
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
                $this->Cell(150, 10, 'No record found.', 1, 0, 'C');
            } else {
                foreach ($participantArray as $participant) {
                    $student = $studentDA->retrieveStudentDetails($participant->userID);
                    $this->Cell(30, 10, $count + 1, 1, 0, 'C');
                    $this->Cell(30, 10, $student['studID'], 1, 0, 'C');
                    $this->Cell(40, 10, $student['studName'], 1, 0, 'C');
                    $this->Cell(50, 10, $student['studEmail'], 1, 0, 'C');
                    $this->Ln();
                    $count++;
                    $this->totalParticipants++;
                    if ($attendanceStatus == 'Attended') {
                        $this->totalAttended++;
                    } else {
                        $this->totalAbsent++;
                    }
                }
            }
        }

        function displayContent() {
            //Display attended participants
            $scheduleID = $_POST['scheduleID'];
            $this->headerTable('Attended');
            $this->getContent($scheduleID, 'Attended');
            //Display absent participants
            $this->headerTable('Absent');
            $this->getContent($scheduleID, 'Absent');
        }

        function displaySummary() {
            $this->Ln();
            $this->Cell(31, 10, "Total Participants : $this->totalParticipants", 0, 1, 'C');
            $attendRate = $this->totalAttended / $this->totalParticipants * 100;
            $absentRate = $this->totalAbsent / $this->totalParticipants * 100;
            $this->Cell(40, 8, "Total Attended : $this->totalAttended ($attendRate%)", 0, 1, 'C');
            $this->Cell(31, 8, "Total Absent : $this->totalAbsent ($absentRate%)", 0, 1, 'C');
        }

    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->contentTitle();
    $pdf->displayContent();
    $pdf->displaySummary();
    $pdf->Output();
}
