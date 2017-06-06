<?php

require_once __DIR__ . '/bootForTest.php';

use PHPUnit\Framework\TestCase;
use Minph\Utility\Pagination;


class PaginationTest extends TestCase
{
    public function setup()
    {
    }

    public function testPagination()
    {
        $page = 6;
        $total = 100;
        $step = 5;
        $paging = new Pagination($page, $total, $step);
        $ret = $paging->build();
        $debug = $paging->debug($ret);
        var_dump($ret);
        var_dump($debug);
        $this->assertTrue(true);
    }
}


