<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../fpdf.php';
require '../Domain/Society.php';
require '../DataAccess/ParticipantsDA.php';
require '../DataAccess/ScheduleDA.php';
require '../DataAccess/StudentDA.php';
session_start();
if (isset($_POST['eventID']) && isset($_POST['scheduleID'])) {

    $eventID = $_POST['eventID'];

    class PDF extends FPDF {

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

        function headerTable() {
            $this->SetFont('Times', 'B', 12);
            $this->Cell(30, 10, 'Status: Attended', 0, 0, 'C');
            $this->Ln();
            //Header
            $this->Cell(30, 10, 'No.', 1, 0, 'C');
            $this->Cell(30, 10, 'Student ID', 1, 0, 'C');
            $this->Cell(40, 10, 'Name', 1, 0, 'C');
            $this->Cell(50, 10, 'Email', 1, 0, 'C');
            $this->Ln();
        }

        function viewTable() {
            $this->SetFont('Times', '', 12);
            $participantsDA = new ParticipantsDA();
            $scheduleID = $_POST['scheduleID'];
            $participantArray = $participantsDA->retrieveByScheduleIdAndAttendanceStatus($scheduleID, 'Attended');
            $studentDA = new StudentDA();
            $count = 1;
            if ($participantArray == null) {
                $this->Cell(60, 10, 'No participant in this schedule yet.', 0, 0, 'C');
            } else {
                foreach ($participantArray as $participant) {
                    $student = $studentDA->retrieveStudentDetails($participant->userID);
                    $this->Cell(30, 10, $count, 1, 0, 'C');
                    $this->Cell(30, 10, $student['studID'], 1, 0, 'C');
                    $this->Cell(40, 10, $student['studName'], 1, 0, 'C');
                    $this->Cell(50, 10, $student['studEmail'], 1, 0, 'C');
                    $this->Ln();
                    $count++;
                }
            }
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->headerTable();
    $pdf->viewTable();
    $pdf->Output();
}