<?php

require_once './utilitesFunctions.php';

function generatePaySlip(
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

) {
  $totalDeductions = $employee + $employeer + 200 + $advancePay + $Lop + $Esi;
  $grossPay = $basicPay + $hra;
  $netPay = $grossPay - $totalDeductions;

  $payPeriod = date('F Y', strtotime('first day of this month'));
  $payDate = date('d/m/Y');
  $paidDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
  $netpayText = utilitesFunctions::numberToWords($netPay);
  


  echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pay Slip</title>
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  </head>
  <body>
    <div
      class="max-w-3xl mx-auto p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-md mt-10"
    >
      <div class="flex justify-between items-center mb-4">
        <div class="">
          <img src="./logo.png" alt="Company Logo" class="mr-5 w-20" />
          <h1 class="text-xl font-bold text-zinc-800 dark:text-zinc-200">
            Estar Engineers Private limited
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
              <td class="font-medium">' . $employeeName . '</td>
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
              <td class="font-[400] textcolor py-1">Pay Period</td>
              <td>:</td>
              <td class="font-medium">' . $payPeriod . '</td>
            </tr>
            <tr>
              <td class="font-[400] textcolor py-1">Pay Date</td>
              <td>:</td>
              <td class="font-medium">' . $payDate . '</td>
            </tr>
          </table>
          <div class="bg-green-50 dark:bg-green-400 p-4 rounded-lg text-left">
            <div>
              <p class="text-2xl font-bold text-black-800 dark:text-black-200">
                ₹' . $netPay . '
              </p>
              <p class="text-sm text-green-900 dark:text-blue-400">
                Employee Net Pay
              </p>
            </div>
            <div class="border-dotted border-b-2 border-gray-400 mt-5"></div>
            <div class="flex flex-col mt-5">
              <p class="mb-2">
                <span class="font-semibold">Paid Days: </span> ' . ($paidDays - $lopDays) . '
              </p>
              <p><span class="font-semibold">LOP Days: </span>'. $lopDays .'</p>
            </div>
          </div>
        </div>
      </div>
      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4 mb-4">
        <div
          class="grid grid-cols-2 gap-4 text-sm text-zinc-600 dark:text-zinc-400"
        >
          <p>
            <span class="font-semibold textcolor">PF A/C Number:</span
            ><span class="font-medium ml-2">' . $pfAccountNumber . '</span>
          </p>
          <p>
            <span class="font-semibold textcolor">UAN:</span
            ><span class="font-medium ml-2">' . $uan . '</span>
          </p>
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
              <p class="font-medium ml-2">₹' . $basicPay . '</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>House Rent Allowance</p>
              <p class="font-medium ml-2">₹' . $hra . '</p>
            </div>
            
          </div>
          <div>
            <h3 class="font-semibold text-zinc-800 dark:text-zinc-200 mb-2">
              DEDUCTIONS
            </h3>
            <div class="flex justify-between mb-2">
              <p>EPF Contribution of Employer</p>
              <p class="font-medium ml-2">₹' . $employeer . '</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>EPF Contribution of Employee</p>
              <p class="font-medium ml-2">₹' . $employee . '</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>Professional Tax</p>
              <p class="font-medium ml-2"> ₹200 </p>
            </div>
            <div class="flex justify-between mb-2">
              <p>Advance Pay</p>
              <p class="font-medium ml-2">₹' . $advancePay . '</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>Loss of Pay</p>
              <p class="font-medium ml-2">₹' . $Lop . '</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>ESI</p>
              <p class="font-medium ml-2">
                ' . ($Esi === 0 ? 'N/A' : '₹' . $Esi) . '
              </p>
            </div>

          </div>
        </div>
      </div>

      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4 mb-4">
        <div class="flex justify-between items-center text-sm text-zinc-600 dark:text-zinc-400 gap-x-10">

          <div
            class="w-full flex justify-between font-semibold text-zinc-800 dark:text-zinc-200"
          >
            <p>Gross Earnings</p>
            <p class="font-medium ml-2">₹' . $grossPay . '</p>
          </div>

          <div
            class="w-full flex justify-between font-semibold text-zinc-800 dark:text-zinc-200"
          >
            <p>Total Deductions</p>
            <p class="font-medium ml-2">₹' . $totalDeductions . '</p>
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
          <p class="text-lg font-bold text-green-800 dark:text-green-200">
            ₹' . $netPay . '
          </p>
        </div>
      </div>



      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4">
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
          <span class="font-medium">Amount In Words</span> : '.ucwords($netpayText).'
        </p>
      </div>

    </div>    
  </body>
</html>
';
}
