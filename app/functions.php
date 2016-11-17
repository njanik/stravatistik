<?php



function getCompleteYear($type, $year = null){

    if(is_null($year)){
        $year = carbon()->now()->year;
    }

    $date = new \Carbon\Carbon('first day of january '.$year);
    $lastDayOfYear = new \Carbon\Carbon('last day of december '.$year);

    $range = collect([]);

    while($date->lte($lastDayOfYear)){

        $range->push([
            'group_date' => $date->toDateString(),
            'total_distance' => 0
        ]);

        $date->addDay();

    }

    return $range;


}


function carbon($dateString = null){
    if(is_null($dateString)){
        return new \Carbon\Carbon();
    }
    return new \Carbon\Carbon($dateString);
}


function timeFromSec($seconds){
    return gmdate('i:s', $seconds);
}




/**
 * Class casting
 *
 * @param string|object $destination
 * @param object $sourceObject
 * @return object
 */
function castObj($destination, $sourceObject)
{
    if (is_string($destination)) {
        $destination = new $destination();
    }
    $sourceReflection = new ReflectionObject($sourceObject);
    $destinationReflection = new ReflectionObject($destination);
    $sourceProperties = $sourceReflection->getProperties();
    foreach ($sourceProperties as $sourceProperty) {
        $sourceProperty->setAccessible(true);
        $name = $sourceProperty->getName();
        $value = $sourceProperty->getValue($sourceObject);
        if ($destinationReflection->hasProperty($name)) {
            $propDest = $destinationReflection->getProperty($name);
            $propDest->setAccessible(true);
            $propDest->setValue($destination,$value);
        } else {
            $destination->$name = $value;
        }
    }
    return $destination;
}
