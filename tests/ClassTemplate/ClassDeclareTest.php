<?php
use ClassTemplate\ClassFile;
use CodeGen\Testing\CodeGenTestCase;
use CodeGen\UseClass;

class ClassFileTest extends CodeGenTestCase
{
    public function testUse()
    {
        $use = new UseClass('\Foo\Bar');
        $this->assertCodeEquals('use Foo\Bar;', $use);
    }

    public function testClassTemplateWithDefaultOptions() 
    {
        $classTemplate = new ClassTemplate\ClassFile('Foo\\Bar2');
        $classTemplate->addProperty('record','Product');
        $classTemplate->addProperty('fields', array( 'lang', 'name' ));
        $classTemplate->addMethod('public','getTwo',array(),'return 2;');
        $classTemplate->addMethod('public','getFoo',array('$i'),'return $i;');
        $this->assertCodeEqualsFile('tests/data/class_simple.fixture', $classTemplate);
        $classTemplate->load();
    }

    public function evalTemplate(ClassFile $classTemplate)
    {
        $code = $classTemplate->render();
        $tmpname = tempnam('/tmp', preg_replace('/\W/', '_', $classTemplate->class->getFullName()));
        file_put_contents($tmpname, $code);
        require $tmpname;
    }

    public function testClassTemplate()
    {
        $classTemplate = new ClassTemplate\ClassFile('Foo\\Bar1',array(
            'template' => 'Class.php.twig',
            'template_dirs' => array('src/ClassTemplate/Templates'),
        ));
        $this->assertTrue($classTemplate);
        $classTemplate->addProperty('record','Product');
        $classTemplate->addProperty('fields', array('lang', 'name'));
        $classTemplate->addMethod('public','getTwo',array(),'return 2;');
        $classTemplate->addMethod('public','getFoo',array('$i'),'return $i;');

        $this->evalTemplate($classTemplate);

        $this->assertTrue(class_exists($classTemplate->class->getFullName()));

        $bar22 = new Foo\Bar1;
        $this->assertTrue($bar22);

        $this->assertEquals('Product', $bar22->record);
        $this->assertEquals(array('lang','name'), $bar22->fields);

        $this->assertTrue(method_exists($bar22,'getTwo'));
        $this->assertTrue(method_exists($bar22,'getFoo'));

        $this->assertEquals(2,$bar22->getTwo());

        $this->assertEquals(3,$bar22->getFoo(3));
    }
}
