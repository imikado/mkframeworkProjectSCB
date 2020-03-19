<?php
  
require_once __DIR__.'/../autoload_unitaire.php';

use PHPUnit\Framework\TestCase;

final class businessAbstractTest extends TestCase {

    public function test_insertItemShoulFinishOk(){

       

        $business=new business_abstract( );
        $state=$business->sendReturn(false,array('test'=>'value'));
        $return=$business->getReturn()->getData('test');

        $this->assertFalse($state);
        $this->assertEquals('value',$return);


    }

}