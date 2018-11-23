<?php
namespace ClearSky\NameGen\Utility;

use Cake\ORM\TableRegistry;

class Generator {

    /**
     * Generate a set of names, each unique within the set.
     * The result set will include <cardinality> names in an array.
     * cardinality == 2 produces given/family names.
     * cardinality == 3 produces given/middle/family names.
     * When cardinality == 3, a check is performed to ensure given and middle
     * names are different.
     * 
     * @param size the number of names to be returned in the result set
     * @param gender the gender of the results, null for any
     * @param locale the locale of the name set, null for any
     * @param cardinality true to include middle name in uniqueness check
     * @return array containing a set of arrays each containing given/middle/family
     */
    static function getNames($size, $gender = null, $locale = null, $cardinality = 2) {

        srand(time());

        $gConditions = [];
        $fConditions = [];

        if (!empty($locale)) {
            $gConditions['locale'] = $fConditions['locale'] = $locale;
        }

        if (!empty($gender)) {
            $gConditions['gender'] = $gender;
        }

        $givenNames = TableRegistry::getTableLocator()->get('NameGenGiven');
        $gNames = $givenNames->find()->where($gConditions)->toArray();
        $familyNames = TableRegistry::getTableLocator()->get('NameGenFamily');
        $fNames = $familyNames->find()->where($fConditions)->toArray();
        if ($cardinality == 3) {
            $middleNames = TableRegistry::getTableLocator()->get('NameGenMiddle');
            $mNames = $middleNames->find()->where($gConditions)->toArray();
        }

        // todo - throw exception if requesting a set larger than what could
        // be reasonably generated from the source set - considering uniqueness

        $results = [];
        $loopCount = 0;
        $maxLoops = max($size * 3, 20);
        while ((count($results) < $size) && ($loopCount < $maxLoops)) {
            $gName = $gNames[rand(0, count($gNames)-1)]->name;
            $fName = $fNames[rand(0, count($fNames)-1)]->name;

            $name = [
                'given' => $gName,
                'family' => $fName,
            ];

            if ($cardinality == 3) {
                // add a middle name that is different from given name
                do {
                    $mName = $mNames[rand(0, count($mNames)-1)]->name;
                } while ($mName == $gName);
                $name['middle'] = $mName;
            }

            // check uniqueness across entire name
            if (!in_array($name, $results)) {
                $results[] = $name;
            }

            $loopCount++;
            $name = $gName = $mName = $fName = null;
        }

        echo $loopCount . "\n";
        return $results;

    }

}
