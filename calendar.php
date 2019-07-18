<?php
/**
*@title  Custom Calendar
*@author   Gheorghe
*@create-date Jul 18, 2019
**/
class Calendar {  
    
    private $currentYear=0;
    private $currentMonth=0;
    private $currentDay=0;
    private $currentDate=null;
    private $daysInMonth=0;
    private $naviHref= null;
    private $dayLabels = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    
    public function __construct() {     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }

    public function getday($year, $month, $day) {
        return $this->_getIndexWeek($year, $month, $day);
    }
     
    public function show() {

        $year  = null;
        $month = null;
         
        if (null == $year && isset($_GET['year'])) {
            $year = $_GET['year'];
        } else if (null == $year) {
            $year = 1990;  
        }          
         
        if (null == $month && isset($_GET['month'])) {
            $month = $_GET['month'];
        } else if (null==$month){
            $month = 1;
        }                  
        
        $this->currentYear=$year;
        $this->currentMonth=$month;
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                    '<div class="box">'.
                    $this->_createNavi().
                    '</div>'.
                    '<div class="box-content">'.
                        '<ul class="label">'.$this->_createLabels().'</ul>';   
                        $content.='<div class="clear"></div>';     
                        $content.='<ul class="dates">';    
                            
                        $weeksInMonth = $this->_weeksInMonth($month,$year);
                        for( $i=0; $i<$weeksInMonth; $i++ ){
                            for($j=0;$j<7;$j++){
                                $content.=$this->_showDay($i*7+$j);
                            }
                        }
                        $content.='</ul>';
                $content.='<div class="clear"></div>';     
            $content.='</div>';
        $content.='</div>';
        return $content;   
    }
     
    private function _showDay($cellNumber) {
         
        if($this->currentDay==0) {
            $firstDayOfTheWeek = $this->_getIndexWeek($this->currentYear,$this->currentMonth,1);
            if(intval($cellNumber) == intval($firstDayOfTheWeek)) {
                $this->currentDay=1;
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ) {
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            $cellContent = $this->currentDay;
            $this->currentDay++;   
        } else {
            $this->currentDate =null;
            $cellContent=null;
        }
         
        return '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
    }
     
    private function _createNavi() {

        $nextMonth = $this->currentMonth==13?1:intval($this->currentMonth)+1;
        $nextYear = $this->currentMonth==13?intval($this->currentYear)+1:$this->currentYear;
        $preMonth = $this->currentMonth==1?13:intval($this->currentMonth)-1;
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
        if ($preYear < 1990 && $preMonth == 13) {
            $preYear = 1990;
            $preMonth = 1;
        }
         
        return
            '<div class="header">'.
                '<a class="prev" href="index.php?index=2&month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.$this->currentMonth.','.$this->currentYear.'</span>'.
                '<a class="next" href="index.php?index=2&month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }
   
    private function _createLabels() {  

        $content='';
        foreach($this->dayLabels as $index=>$label){
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
        }
        return $content;
    }
     
    private function _weeksInMonth($month=null,$year=null) {

        if( null==($year) ) {
            $year =  1990; 
        }
        if(null==($month)) {
            $month = 1;
        }
        $daysInMonths = $this->_daysInMonth($month,$year);
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay = $this->_getIndexWeek($year,$month,$daysInMonths);
        $monthStartDay = $this->_getIndexWeek($year,$month,1);

        if($monthEndingDay < $monthStartDay) {
            $numOfweeks++;
        }
        return $numOfweeks;
    }

    private function _daysInMonth($month = null, $year = null) {

        if ($this->_is_leap_year($year) == true && $month == 13) {
            return 21;
        } else {
            if (($month % 2) == 0)
                return 21;
            else
                return 22;
        }
    }
     
    private function _is_leap_year($year) {
        return (($year % 5) == 0);
    }

    private function _getIndexWeek($year, $month, $day) {
        $sum = 0;
        $leap = $this->_getLeapcnt($year);
        for ($i = 1990; $i <= $year; $i++) {
            if ($i == $year) {
                for ($j = 1; $j <= $month; $j++) {
                    if ($j == $month) {
                        $sum+=$day;
                    } else {
                        $j%2==0?$sum+=21:$sum+=22;
                    }
                }
            } else {
                for ($j = 1; $j <= 13; $j++) {
                    $j%2==0?$sum+=21:$sum+=22;
                }
            }
        }
        return ($sum-$leap)%7;

    }

    private function _getLeapcnt($year) {
        $cnt = 0;
        for ($i=1990; $i < $year; $i++) {
            if ($this->_is_leap_year($i))
                $cnt++;
        }
        return $cnt;
    }
}