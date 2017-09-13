<?php
/*
Принимает начало и конец даты в формате 'ГГГГ-ММ-ДД'(2011-10-20) (номер даты и месяца с ведущим нулем),
массив holiday в таком же формате. Если праздник выходит на выходной день, то в расчет не берётся
*/
function holidaysCount($dateStart, $dateEnd, $holidays) {

    function formatDate ($date) {
        $form1 = date_parse($date);
        $form2 = mktime(0,0,0, $form1["month"], $form1["day"], $form1["year"]);
        return getdate($form2);
    }
   
    $start = formatDate($dateStart);
    $end = formatDate($dateEnd);
    $count = 0;

    for($i = $start[0]; $i <= $end[0]; $i += 86400) {
        $day = getdate($i)["weekday"];
        if ($day === "Saturday" || $day === "Sunday") {
            $count++;
        } else if (in_array(date('Y-m-d', $i), $holidays)) {
            $count++;
        }
    }

    return $count;
}
/*
Пример. 

Результат 11:
    8 дней выходных
    3 дня праздничных (2017-08-05 попадает на выходной день)
*/
$holidays = ["2017-08-05", "2017-08-17", "2017-08-23", "2017-08-07"];
$dateStart = "2017-08-01";
$dateEnd = "2017-08-31";
echo holidaysCount($dateStart, $dateEnd, $holidays);