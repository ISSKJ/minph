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

}
