<?php
error_reporting(0);
set_time_limit(300);

require_once './vendor/autoload.php';
require_once './utilitesFunctions.php';
require_once './Payslip_template.php';
require_once './htmlToimage.php';


// Path to your Excel file
$inputFileName = './input/payslip.xlsx';

// Set the input file name in the static class
utilitesFunctions::setInputFileName($inputFileName);

// Convert the Excel data to JSON
$jsonData = utilitesFunctions::convertToJson();

$datas = json_decode($jsonData, true);

$payPeriod = date('F Y', strtotime('first day of last month'));

// Output the JSON data
foreach ($datas as $key => $value) {
  if ($key !== 0) {

    $joing_Date_format = utilitesFunctions::excelDateToDateTime($value[3]);
    $pay_Date_formatted = utilitesFunctions::excelDateToDateTime($value[13]);

    $employeeName = strtoupper($value[0]);    // Emp Name
    $designation = ucwords($value[1]);        // Emp Designation
    $employeeID = $value[2];                  // Emp ID
    $dateOfJoining = $joing_Date_format;      // DOJ
    $uan = $value[4];                         // UAN
    $basicPay = $value[5];                    // Basic Pay
    $hra = $value[6];                         // HRA
    $employee = $value[7];                    // Employee
    $employeer = $value[8];                   // Employer
    $advancePay = $value[9];                 // Advance Pay
    $Lop = $value[10];                        // LOP Amount
    $Esi = $value[11];                        // ESI
    $lopDays = $value[12];                    // LOP Days
    $paydate = $pay_Date_formatted;           // Pay Date
    $splAllownace = $value[14];               // Special Allowance
    $grautuity = $value[15];                  // Gratuity
    $otherDeductions = $value[16];            // Other Deductions



    $payslipOpt = generatePaySlip(
      $employeeName,
      $designation,
      $employeeID,
      $dateOfJoining,
      $uan,
      $basicPay,
      $hra,
      $employee,
      $employeer,
      $advancePay,
      $Lop,
      $Esi,
      $lopDays,
      $paydate,
      $splAllownace,
      $grautuity,
      $otherDeductions
    );

    echo $payslipOpt;

  // $empName = "./output/".ucwords($value[0])." - Pay Slip - ". $payPeriod.".pdf";
  // echo $empName."<br/>";
  // htmlToPdf($payslipOpt, $empName);

 
  }
};
