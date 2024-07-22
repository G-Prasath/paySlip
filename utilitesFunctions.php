<?php

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


class utilitesFunctions
{
    private static $inputFileName;

    public static function setInputFileName($fileName)
    {
        self::$inputFileName = $fileName;
    }

    public static function convertToJson()
    {
        if (!self::$inputFileName) {
            throw new Exception("Input file name is not set.");
        }

        // Load the spreadsheet
        $spreadsheet = IOFactory::load(self::$inputFileName);

        // Get the first worksheet in the spreadsheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Get the highest row and column numbers referenced in the worksheet
        $highestRow = $worksheet->getHighestRow(); // e.g. 10
        $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        $data = [];

        // Loop through each row of the worksheet in turn
        for ($row = 1; $row <= $highestRow; ++$row) {
            $rowData = [];
            for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                $rowData[] = $cellValue;
            }
            $data[] = $rowData;
        }

        // Convert the array to JSON format
        $json = json_encode($data, JSON_PRETTY_PRINT);

        return $json;
    }

    public static function numberToWords($number)
    {
        // Array of units and corresponding words
        $units = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine');

        // Array of tens and corresponding words
        $tens = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');

        // Array of special cases for numbers 11 to 19
        $special_cases = array('eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');

        // Determine the length of the number
        $num_length = strlen($number);

        // Initialize an empty array to store the words
        $words = array();

        // Convert each digit of the number to words
        switch ($num_length) {
            case 1:
                $words[] = $units[$number % 10];
                break;
            case 2:
                if ($number < 20) {
                    $words[] = $special_cases[$number - 11];
                } else {
                    $words[] = $tens[floor($number / 10)];
                    $words[] = $units[$number % 10];
                }
                break;
            case 3:
                $words[] = $units[floor($number / 100)] . ' hundred';
                $number %= 100;
                if ($number != 0) {
                    $words[] = self::numberToWords($number); // Recursive call within the class
                }
                break;
            case 4:
            case 5:
            case 6:
                $base_unit = pow(10, floor(($num_length - 1) / 3) * 3);
                $words[] = self::numberToWords(floor($number / $base_unit));
                $words[] = ($base_unit >= 1000) ? 'thousand' : 'million';
                $number %= $base_unit;
                if ($number != 0) {
                    $words[] = self::numberToWords($number); // Recursive call within the class
                }
                break;
            default:
                $words[] = 'invalid number'; // Handles numbers beyond current implementation
                break;
        }

        // Return the words as a single string
        return implode(' ', $words);
    }

    public static function excelDateToDateTime($excelDate)
    {
        $unixDate = ($excelDate - 25569) * 86400; // 25569 is the number of days between 1900-01-01 and 1970-01-01
        return gmdate("d-m-Y", $unixDate); // format as 'YYYY-MM-DD'
    }


}
