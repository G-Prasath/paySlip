<?php
error_reporting(0);
set_time_limit(300);

require_once 'vendor/autoload.php';
require_once './utilitesFunctions.php';
require_once './Payslip_template.php';
require_once './htmlToimage.php';


// Path to your Excel file
$inputFileName = 'payslip.xlsx';

// Set the input file name in the static class
utilitesFunctions::setInputFileName($inputFileName);

// Convert the Excel data to JSON
$jsonData = utilitesFunctions::convertToJson();

$datas = json_decode($jsonData, true);

$payPeriod = date('F Y', strtotime('first day of this month'));

// Output the JSON data
foreach ($datas as $key => $value) {
  if ($key !== 0) {
    $formattedDate = utilitesFunctions::excelDateToDateTime($value[3]);

    $employeeName = strtoupper($value[0]);       // Emp Name
    $designation = ucwords($value[1]);        // Emp Designation
    $employeeID = $value[2];                  // Emp ID
    $dateOfJoining = $formattedDate;          // DOJ
    $pfAccountNumber = $value[4];             // PF Ac
    $uan = $value[5];                         // UAN
    $basicPay = $value[6];                    // Basic Pay
    $hra = $value[7];                         // HRA
    $employee = $value[8];                    // Employee
    $employeer = $value[9];                   // Employer
    $advancePay = $value[10];                 // Advance Pay
    $Lop = $value[11];                        // LOP Amount
    $Esi = $value[12];                        // ESI
    $lopDays = $value[13];                    // LOP Days


    $payslipOpt = generatePaySlip(
      $employeeName,
      $designation,
      $employeeID,
      $dateOfJoining,
      $pfAccountNumber,
      $uan,
      $basicPay,
      $hra,
      $employee,
      $employeer,
      $advancePay,
      $Lop,
      $Esi,
      $lopDays
    );

    // echo $payslipOpt;

  $empName = ucwords($value[0])."- Pay Slip -". $payPeriod;
  htmlToPdf($payslipOpt, $empName);

 
  }
};
