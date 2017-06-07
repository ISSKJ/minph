<?php

namespace Minph\Utility;


/**
 * @class Minph\Utility\Pagination
 */
class Pagination
{
    private $page;
    private $total;
    private $step;

    /**
     * @method construct
     * @param int `$page`
     * @param int `$total`
     * @param int `$step`
     */
    public function __construct($page, $total, $step)
    {
        $this->page = $page;
        $this->total = (int)ceil($total / $step);
        $this->step = $step;
    }

    /**
     * @method build
     * @return array paging information
     *
     * Sample return:
     *
     * ```
     * returns [
     *     'page' => 1,
     *     'toal' => 100,
     *     'activePrev' => true,
     *     'activeNext' => true,
     *     'leftCollapse' => true,
     *     'rightCollapse' => true,
     * ];
     * ```
     */
    public function build()
    {
        $activePrev = ($this->page !== 1);
        $activeNext = ($this->page !== $this->total);
        $allPage = ($this->total <= 5);
        $leftCollapse = false;
        $rightCollapse = false;

        if ($allPage) {
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

    private function debug(array $page)
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
