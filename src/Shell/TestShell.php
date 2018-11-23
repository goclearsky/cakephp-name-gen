<?php
namespace ClearSky\NameGen\Shell;

use Cake\Console\Shell;
use Croogo\Core\Plugin;
use ClearSky\NameGen\Utility\Generator;

/**
 * Test Shell
 *
 * Provides a testing platform for the plugin
 *
 * @category Shell
 * @package  ClearSky.NameGen
 * @author   Mike Tallroth <mike.tallroth@goclearsky.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://github.com/goclearsky/cakephp-name-gen
 */
class TestShell extends Shell
{

    /**
     * getOptionParser
     */
    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->description('Croogo Settings utility')
            ->addSubcommand('name', [
                'help' => __d('croogo', 'Name'),
            ]);
    }

    public function name()
    {
        $this->out("name");

        $cardinality = 2;
        $names = Generator::getNames(10, 'M', 'en_US', $cardinality);
        foreach ($names as $name) {
            if ($cardinality == 3) {
                printf("%12s %12s %12s\n", $name['given'], $name['middle'], $name['family']);
            } else {
                printf("%12s %12s\n", $name['given'], $name['family']);
            }
        }
    }

}
