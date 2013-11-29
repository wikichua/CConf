<?php namespace CConf;

require_once 'ConfFactory.php';
require_once 'ConfBuilder.php';

/**
 * ConfigTest
 *
 * @group group
 */
class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers class::ableToSetAndGetDataAsArray()
     */
    public function testAbleToSetAndGetDataAsArray()
    {
    	$example1 = [
    		'example1'=>[
    			'test'=>'test1',
    			'test2'=>'test3',
    			'test4'=>[
    				'test5'=>'test6',
    				'test7'=>'test8'
    			]
    		]
    	];

        $Conf = new ConfBuilder;
    	$Conf->set($example1);
    	$result = $Conf->get('example1.test4.test7');

    	$this->assertEquals('test8', $result);
    }

    /**
     * @covers class::ableToSetAndGetDataAsSingle()
     */
    public function testAbleToSetAndGetDataAsSingle()
    {

        $Conf = new ConfBuilder;
        $Conf->set('example2.test2','hello world');
        $Conf->set('example2.test3',['hello','again']);
        $result1 = $Conf->get('example2.test2');
        $this->assertEquals('hello world', $result1);
        $result1 = $Conf->get('example2.test3');
        $this->assertCount(2, $result1);
    }

    /**
     * @covers class::ableToGetDataFromConfigDirectory()
     */
    public function testAbleToGetDataFromConfigDirectory()
    {
        $Conf = new ConfBuilder;
        $Conf->setConfigDirectory(__dir__ . '/config/');

    	$result = $Conf->get('example.test');
    	$this->assertEquals('test1', $result);
    	$result1 = $Conf->get('example.test2');
    	$this->assertCount(2, $result1);

        $Conf->set(['example'=>['test2'=>'hello world']]);
        $result1 = $Conf->get('example.test2');
        $this->assertEquals('hello world', $result1);
    }
}
