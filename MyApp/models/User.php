<?php
class User {
    private $name;
    private $studentInfo;
    function __construct($param)
    {
        #$this->get_studentInfo($param[0]);
        $this->studentInfo[0] = $param['id'];
        if(!array_key_exists("local",$param)){
            $this->studentInfo[1] = $param['uName'];
            $this->studentInfo[2] = $param['roll'];
            $this->studentInfo[3] = $param['marks'];
            $this->studentInfo[4] = $param['fullmarks'];
        }
        else
        {
            $this->get_studentInfo($param['id']);            
        }
        #return 'User';
    }
    function get_userName(){
        return $this->studentInfo[1];
    }
    function set_userName($uName){
        $this->studentInfo[1] = $uName;
    }
    function get_userScore(){
        return array($this->studentInfo[3],$this->studentInfo[4]);
    }
    function set_userScore($uScore){
        $this->studentInfo[3] = $uScore[0];
        $this->studentInfo[4] = $uScore[1];
    }
    function get_userRoll(){
        return $this->studentInfo[2];
    }
    
    function set_userRoll($roll){
        $this->studentInfo[2] = $roll;
    }
    function get_studentInfo($id){
        $util = new StudentUtility();
        $this->studentInfo = $util->getStudentData($id);
    }
    function get_currStudentInfo(){
        return $this->studentInfo ;
    }
}

?>