<?php


use PHPUnit\Framework\TestCase;
use Minph\Utility\Pagination;


class PaginationTest extends TestCase
{
    private $total;
    private $step;

    public function setup()
    {
        $this->total = 100;
        $this->step = 10;
    }

    public function testPagination()
    {
        $this->paginationCheck(1, false, true, true, false);
        $this->paginationCheck(2, true, true, true, false);
        $this->paginationCheck(3, true, true, true, false);
        $this->paginationCheck(4, true, true, true, false);
        $this->paginationCheck(5, true, true, true, true);
        $this->paginationCheck(6, true, true, false, true);
        $this->paginationCheck(7, true, true, false, true);
        $this->paginationCheck(8, true, true, false, true);
        $this->paginationCheck(9, true, true, false, true);
        $this->paginationCheck(10, true, false, false, true);
    }

    public function paginationCheck($page, $activePrev, $activeNext, $leftCollapse, $rightCollapse)
    {
        $paging = new Pagination($page, $this->total, $this->step);
        $ret = $paging->build();
        $this->assertEquals($ret['total'], 10);
        $this->assertEquals($ret['activePrev'], $activePrev);
        $this->assertEquals($ret['activeNext'], $activeNext);
        $this->assertEquals($ret['leftCollapse'], $leftCollapse);
        $this->assertEquals($ret['rightCollapse'], $rightCollapse);
    }

    public function debug(array $page)
    {
        $ret = '';
        if ($page['activePrev']) {
            $ret .= ' Prev ';
        }

        if ($page['leftCollapse']) {
            for ($i = 1; $i <= 5; $i++) {
                if ($i === $page['page']) {
                    $ret .= " [$i] ";
                } else {
                    $ret .= " $i ";
                }
            }
        } else {
            for ($i = 1; $i <= 2; $i++) {
                if ($i === $page['page']) {
                    $ret .= " [$i] ";
                } else {
                    $ret .= " $i ";
                }
            }
            $ret .= " .. ";
        }

        if (!$page['leftCollapse'] && !$page['rightCollapse']) {
            for ($i = $page['page']-2; $i <= $page['page']+2; $i++) {
                if ($i === $page['page']) {
                    $ret .= " [$i] ";
                } else {
                    $ret .= " $i ";
                }
            }
        }

        if ($page['rightCollapse']) {
            for ($i = $page['total'] - 4; $i <= $page['total']; $i++) {
                if ($i === $page['page']) {
                    $ret .= " [$i] ";
                } else {
                    $ret .= " $i ";
                }
            }
        } else {
            $ret .= " .. ";
            for ($i = $page['total'] - 1; $i <= $page['total']; $i++) {
                if ($i === $page['page']) {
                    $ret .= " [$i] ";
                } else {
                    $ret .= " $i ";
                }
            }
        }
        if ($page['activeNext']) {
            $ret .= ' Next ';
        }
        return $ret;
    }
}


