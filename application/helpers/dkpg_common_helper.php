<?php
function dkpg_date2sql ($date) {
    list($dd, $mm, $yyyy) = explode('-', $date, 3);
    if(!checkdate($mm,$dd,$yyyy)) {
        return "";
    }
    $datesql = $yyyy .'-'. $mm . '-' . $dd;
    return date('Y-m-d',strtotime($datesql));

}

function dkpg_getage($dob, $current)
{
    
    $interval = date_diff(date_create($current), date_create($dob));
    $Y = $interval->format("%Y");
    $n = $interval->format("%m");
    $j = $interval->format("%d");
    $res = $Y . ' Tahun';
    $res .= $n > 0 ? ', '.$n . ' Bulan' : "";
    $res .= $j > 0 ? ', '.$j . ' Hari' : "";
    
    return $res;
}