<?php
class StudentUtility {
    public function getStudentData($studentid)
    {
        $studentsData = $this->getAllData();
        for ($i=0; $i < count($studentsData); $i++) { 
            if (in_array($studentid, $studentsData[$i]))
            {
                    return $studentsData[$i];
            }
        }
    }
    public function getAllData()
    {
        $students = $this->readCSV();    
        return $students;        
    }
    private function readCSV()
    {

        $filename = 'Y:\xampp\htdocs\MyApp\contents\student.csv';
        // The nested array to hold all the arrays
        $studentData = []; 

        // Open the file for reading
        if (($h = fopen("{$filename}", "r")) !== FALSE) 
        {
            // Each line in the file is converted into an individual array that we call $data
            // The items of the array are comma separated
            while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
            {
                // Each individual array is being pushed into the nested array
                $studentData[] = $data;		
            }

        // Close the file
        fclose($h);
        }
        return $studentData;
    }
}