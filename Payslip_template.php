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

  $imgPath = "./logo.png";
  $base64Image = base64_encode(file_get_contents($imgPath));

  return '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset=\"UTF-8\">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pay Slip</title>
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
     <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
  </head>
  <body>
    <div
      class="max-w-5xl mx-auto p-6 bg-white dark:bg-zinc-800 rounded-lg mt-10"
      id="payslip"
    >
      <div class="flex justify-between items-center mb-4">
        <div class="">
          <img src="data:image/jpeg;base64,' . $base64Image . '" alt="Company Logo" class="mr-5 w-20">
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
                ' . $netPay . '.00
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
              <p class="font-medium ml-2">&#8377; ' . $basicPay . '.00</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>House Rent Allowance</p>
              <p class="font-medium ml-2">&#8377; ' . $hra . '.00</p>
            </div>
            
          </div>
          <div>
            <h3 class="font-semibold text-zinc-800 dark:text-zinc-200 mb-2">
              DEDUCTIONS
            </h3>
            <div class="flex justify-between mb-2">
              <p>EPF Contribution of Employer</p>
              <p class="font-medium ml-2">&#8377; ' . $employeer . '.00</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>EPF Contribution of Employee</p>
              <p class="font-medium ml-2">&#8377; ' . $employee . '.00</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>Professional Tax</p>
              <p class="font-medium ml-2"> &#8377; 200.00 </p>
            </div>
            <div class="flex justify-between mb-2">
              <p>Advance Pay</p>
              <p class="font-medium ml-2">&#8377; ' . $advancePay . '.00</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>Loss of Pay</p>
              <p class="font-medium ml-2">&#8377; ' . $Lop . '.00</p>
            </div>
            <div class="flex justify-between mb-2">
              <p>ESI</p>
              <p class="font-medium ml-2">
                ' . ($Esi === 0 ? 'N/A' : '&#8377; ' . $Esi.".00") . '
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
            <p class="font-medium ml-2">&#8377; ' . $grossPay . '.00</p>
          </div>

          <div
            class="w-full flex justify-between font-semibold text-zinc-800 dark:text-zinc-200"
          >
            <p>Total Deductions</p>
            <p class="font-medium ml-2">&#8377; ' . $totalDeductions . '.00</p>
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
            &#8377; ' . $netPay . '.00
          </p>
        </div>
      </div>



      <div class="border-t border-zinc-300 dark:border-zinc-700 pt-4">
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
          <span class="font-bold">Amount In Words</span> : '.ucwords($netpayText).'
        </p>
      </div>

    </div>  

    <!-- <script>
      var element = document.getElementById("payslip");
      console.log(payslip);
      var empName = document.getElementById("empName").innerText;
    
      html2canvas(element).then(function (canvas) {
        canvas.toBlob(function (blob) {
          var link = document.createElement("a");
          link.href = URL.createObjectURL(blob);
          link.download = "Payslip.jpg";
          link.click();
          URL.revokeObjectURL(link.href);
        }, "image/jpeg", 1.0);
      });
    </script> -->

  </body>
</html>
';
}
