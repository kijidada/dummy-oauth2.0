<?php
class StudentUtility {
    private function AuthenticateUserFromCSV($studentid,$pwd)
    {   
        $genconfig = $this->getConfigValue('general',array('rollidx'=>'','pwdidx'=>''));
        $rollidx = (int)$genconfig['rollidx'];
        $pwdidx = (int)$genconfig['pwdidx'];
        $studentsData = $this->getAllData();
        $encPwd = $pwd;
        for ($i=0; $i < count($studentsData); $i++) {
            if($studentsData[$i][$rollidx] == $studentid && $studentsData[$i][$pwdidx] == $encPwd)
                return true;
        }
        return false;
    }


    
    public function checkUser($uName,$pwd){
        $genconfig = $this->getConfigValue('general',array('dbmode'=>''));        
        $dbmode = $genconfig['dbmode'];
        if($dbmode == 1)
            return $this->AuthenticateUserFromDB($uName,$pwd);
        else
            return $this->AuthenticateUserFromCSV($uName,$pwd) ;
    }






    private function AuthenticateUserFromDB($uName,$pwd ){        
        $db = $this->getConfigValue('db_user',array('dbname'=>'','host'=>'','username'=>'','password'=>''));
        $dsn = 'mysql:dbname='.$db['dbname'].';host='.$db['host'];
        $username = $db['username'];
        $password = $db['password'];
        try {
            $conn = new PDO($dsn, $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $alldata = $conn->query("SELECT * FROM oauth_users where roll='".$uName."' AND password='".sha1($pwd)."'")->fetch();            
            $conn = null;
            if(!$alldata)
                $alldata = array();
        }
        catch(PDOException $e)
        {
            $conn =null;
        }
        return !empty($alldata);
    }

    public function getAllData()
    {
        $students = $this->readCSV();    
        return $students;        
    }
    private function readCSV()
    {
        $genconfig = $genconfig = $this->getConfigValue('general',array('csvpath'=>''));
        $filename = $genconfig['csvpath'];
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

    public function getConfigValue($section, $dict)
    {
        $config = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/OauthServer/config/appconfig_dev.ini',1);
        $config_section = $config[$section];
        foreach ($dict as $key=>$value) {
            $dict[$key] = $config_section[$key];
        }
        return $dict;
    }


}