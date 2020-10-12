<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
            $appURL = env('APP_URL');
    
            $urls = [
                '/',
                '/admin/users',
                '/admin' 
            ];
    
            echo  PHP_EOL;
    
            foreach ($urls as $url) {
                $response = $this->get($url);
                if((int)$response->status() !== 200){
                    echo  $appURL . $url . ' (FAILED) did not return a 200.';
                    $this->assertTrue(false);
                } else {
                    echo $appURL . $url . ' (success ?)';
                    $this->assertTrue(true);
                }
                echo  PHP_EOL;
            }
    
    }
    
}
