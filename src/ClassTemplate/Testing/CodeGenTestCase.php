<?php
namespace ClassTemplate\Testing;
use ClassTemplate\Renderable;
use PHPUnit_Framework_TestCase;

class CodeGenTestCase extends PHPUnit_Framework_TestCase
{

    public function assertCodeEqualsFile($fixtureFile, Renderable $code, array $args = array()) {
        $out = $code->render($args);
        if (!file_exists($fixtureFile) || getenv('OVERRIDE_FIXTURE') ) {
            echo "\nGenerating fixture file with below content: $fixtureFile\n";
            echo "======================\n";
            echo $out . "\n";
            echo "======================\n";
            file_put_contents($fixtureFile, $out);
        }
        $this->assertStringEqualsFile($fixtureFile, $out, "Testing $fixtureFile");
    }


}


