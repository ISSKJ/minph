<?php

namespace Minph\Utility;


class Pagination
{
    private $page;
    private $total;
    private $step;

    public function __construct(int $page, int $total, int $step)
    {
        $this->page = $page;
        $this->total = (int)ceil($total / $step);
        $this->step = $step;
    }

    public function build()
    {
        $activePrev = ($this->page !== 1);
        $activeNext = ($this->page !== $this->total);
        $allpage = ($this->total <= 5);
        $leftCollapse = false;
        $rightCollapse = false;

        if ($allpage) {
            return [
                'page' => $this->page,
                'total' => $this->total,
                'activePrev' => $activePrev,
                'activeNext' => $activeNext,
                'leftCollapse' => $leftCollapse,
                'rightCollapse' => $rightCollapse
            ];
        }
        
        if ($this->page <= 5) {
            $leftCollapse = true;
        }

        if (($this->total - $this->page) <= 5) {
            $rightCollapse = true;
        }

        return [
            'page' => $this->page,
            'total' => $this->total,
            'activePrev' => $activePrev,
            'activeNext' => $activeNext,
            'leftCollapse' => $leftCollapse,
            'rightCollapse' => $rightCollapse
        ];
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
            for ($i = $page['total'] - 5; $i <= $page['total']; $i++) {
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
