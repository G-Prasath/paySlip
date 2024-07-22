<?php

require_once './utilitesFunctions.php';

function generatePaySlip(
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
  $payDate,
  $splAllownace,
  $grautuity,
  $otherDeductions

) {
  $totalDeductions = $employee + $employeer + 200 + $advancePay + $Lop + $Esi;
  $grossPay = $basicPay + $hra + $splAllownace;
  $netPay = $grossPay - $totalDeductions;

  $payPeriod = date('F Y', strtotime('first day of last month'));
  // $payDate = date('d/m/Y');
  $paidDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
  $netpayText = utilitesFunctions::numberToWords($netPay);

  $imgPath = "./estar-logo.png";
  $base64Image = base64_encode(file_get_contents($imgPath));

  $inr = "./currency.png";
  $inrBasae64 = base64_encode(file_get_contents($inr));

  $inr2 = "./exchange.png";
  $inr2Basae64 = base64_encode(file_get_contents($inr2));

  return '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pay Slip</title>
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <style>
      .inr-style{
        display: flex;
        align-items: center;
        jus
      }
    </style>
     <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
  </head>
  <body>
    <div
      class="max-w-5xl mx-auto p-6 bg-white dark:bg-zinc-800 rounded-lg mt-10"
      id="payslip"
    >
      <div class="flex justify-between items-center mb-4">
        <div class="">
          <img src="data:image/jpeg;base64,' . $base64Image . '" alt="Company Logo" class="mr-5 w-20 mb-2">
          <h1 class="text-xl font-bold text-zinc-800 dark:text-zinc-200">
            E STAR ENGINEERING PVT. LTD.
          </h1>
          <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Tamil Nadu, India.
          </p>
        </div>
        <div class="text-right">
          <p class="text-sm textcolor">Payslip For the Month</p>
          <p class="text-lg font-bold text-zinc-800 dark:text-zinc-200">
            ' . $payPeriod . '
          </p>
        </div>
      </div>
      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4 mb-4">
        <h2 class="text-md font-semibold text-zinc-800 dark:text-zinc-200 mb-2">
          EMPLOYEE SUMMARY
        </h2>
        <div
          class="grid grid-cols-2 gap-4 text-sm text-zinc-600 dark:text-zinc-400"
        >
          <table class="border-separate border-spacing-5">
            <tr class="">
              <td class="font-[400] textcolor py-1">Employee Name</td>
              <td>:</td>
              <td class="font-medium" id="empName">' . $employeeName . '</td>
            </tr>
            <tr>
              <td class="font-[400] textcolor py-1">Designation</td>
              <td>:</td>
              <td class="font-medium">' . $designation . '</td>
            </tr>
            <tr>
              <td class="font-[400] textcolor py-1">Employee ID</td>
              <td>:</td>
              <td class="font-medium">' . $employeeID . '</td>
            </tr>
            <tr>
              <td class="font-[400] textcolor py-1">Date of Joining</td>
              <td>:</td>
              <td class="font-medium">' . $dateOfJoining . '</td>
            </tr>
            <tr>
              <td class="font-[400] textcolor py-1">UAN No</td>
              <td>:</td>
              <td class="font-medium">' . $uan . '</td>
            </tr>
            <tr>
              <td class="font-[400] textcolor py-1">Pay Date</td>
              <td>:</td>
              <td class="font-medium">' . $payDate . '</td>
            </tr>
          </table>
          <div class="bg-green-50 dark:bg-green-400 p-4 rounded-lg text-left">
            <div>
              <p class="text-2xl font-bold text-black-800 dark:text-black-200 inr-style" >
                <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-7 h-6">
                <span>' . $netPay . '.00</span>                
              </p>
              <p class="text-sm text-green-900 dark:text-blue-400">
                Employee Net Pay
              </p>
            </div>
            <div class="border-dotted border-b-2 border-gray-400 mt-5"></div>
            <div class="flex flex-col mt-5">
              <p class="mb-2">
                <span class="font-semibold">Total Working Days: </span> ' . $paidDays . '
              </p>
              <p class="mb-2">
                <span class="font-semibold">Paid Days: </span> ' . ($paidDays - $lopDays) . '
              </p>
              <p><span class="font-semibold">LOP Days: </span>' . $lopDays . '</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4 mb-4">
        <div
          class="grid grid-cols-2 gap-4 text-sm text-zinc-600 dark:text-zinc-400"
        >
          <div class="mr-10">
            <h3 class="font-semibold text-zinc-800 dark:text-zinc-200 mb-2">
              EARNINGS
            </h3>
            <div class="flex justify-between mb-2">
              <p>Basic</p>
              <p class="font-medium ml-2 inr-style"> 
                <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">
                <span>' . $basicPay . '.00</span>
              </p>
            </div>
            <div class="flex justify-between mb-2">
              <p>House Rent Allowance</p>
              <p class="font-medium ml-2 inr-style"> 
              <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">
              ' . $hra . '.00</p>
            </div>

            <div class="flex justify-between mb-2">
              <p>Special Allowance</p>
              <p class="font-medium ml-2 inr-style"> 
              <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">
              ' . $splAllownace . '.00</p>
            </div>
            
          </div>
          <div>
            <h3 class="font-semibold text-zinc-800 dark:text-zinc-200 mb-2">
              DEDUCTIONS
            </h3>
            <div class="flex justify-between mb-2">
              <p>EPF Contribution of Employer</p>
              <p class="font-medium ml-2 inr-style"> 
                <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4"> 
                ' . $employeer . '.00</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>EPF Contribution of Employee</p>
              <p class="font-medium ml-2 inr-style"> 
              <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">
              ' . $employee . '.00</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>Professional Tax</p>
              <p class="font-medium ml-2 inr-style"> 
              <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4"> 
              200.00 
              </p>
            </div>
            <div class="flex justify-between mb-2">
              <p>Advance Pay</p>
              <p class="font-medium ml-2 inr-style"> 
              <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">
              ' . $advancePay . '.00</p>
            </div>

            <div class="flex justify-between mb-2">
              <p>Gratuity</p>
              <p class="font-medium ml-2 inr-style"> 
                ' . ($grautuity === 0
                  ? 'N/A'
                  : ' <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">' . $grautuity . ".00")
                  . '
              </p>
            </div>

            <div class="flex justify-between mb-2">
              <p>Other Deductions</p>
              <p class="font-medium ml-2 inr-style"> 
              <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">
              ' . $otherDeductions . '.00</p>
            </div>

            <div class="flex justify-between mb-2">
              <p>LOP Amount</p>
              <p class="font-medium ml-2 inr-style"> 
              <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">
              ' . $Lop . '.00</p>
            </div>

            <div class="flex justify-between mb-2">
              <p>ESI</p>
              <p class="font-medium ml-2 inr-style">
                ' . ($Esi === 0
                  ? 'N/A'
                  : ' <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">' . $Esi . ".00")
                  . '
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4 mb-4">
        <div class="flex justify-between items-center text-sm text-zinc-600 dark:text-zinc-400  ">

          <div
            class="w-full flex justify-between font-semibold text-zinc-800 dark:text-zinc-200 pr-10"
          >
            <p>Gross Earnings</p>
            <p class="font-medium inr-style">
            <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4"> 
            ' . $grossPay . '.00
            </p>
          </div>

          <div
            class="w-full flex justify-between font-semibold text-zinc-800 dark:text-zinc-200"
          >
            <p>Total Deductions</p>
            <p class="font-medium ml-2 inr-style">
            <img src="data:image/jpeg;base64,' . $inrBasae64 . '" alt="Company Logo" class="w-5 h-4">
             ' . $totalDeductions . '.00
             </p>
          </div>

        </div>
      </div>

      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4 mb-4">
        <div
          class="flex justify-between items-center text-sm text-zinc-600 dark:text-zinc-400"
        >
          <p class="font-semibold text-zinc-800 dark:text-zinc-200">
            TOTAL NET PAYABLE
          </p>
          <p class="text-lg font-bold text-green-800 dark:text-green-200 inr-style">
              <img src="data:image/jpeg;base64,' . $inr2Basae64 . '" alt="Company Logo" class="w-6 h-5">
             <span>' . $netPay . '.00</span>
          </p>
        </div>
      </div>



      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4 flex justify-end">
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
          <span class="font-bold">Amount In Words</span> : ' . ucwords($netpayText) . ' Only
        </p>
      </div>


    <div class="mt-12">
      <p>** This is a computer-generated Pay slip hence no signature is required</p>
    </div>
    </div>  

  </body>
</html>
';
}
