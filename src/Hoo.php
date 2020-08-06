<?php


namespace Solyamls\Hoo;


class Hoo
{
    private $total;
    private $current;
    private $rate;
    private $lastPercent = 0;
    private $piece;
    private $percent = 0;
    private $startTime;

    public function __construct($current = 0,$total = 100,$piece = '#')
    {
        $this->startTime = microtime(true);
        $this->current   = $current;
        $this->total     = $total;
        $this->piece     = $piece;
        $this->rate      = $this->piece;

    }

    public function play($current)
    {
        $this->current     = $current;
        $this->lastPercent = $this->percent;
        $this->percent     = intval( 100 * $this->current / $this->total);
        if ($this->total >= 100){
            if (($this->percent % 2 == 0) && $this->percent != $this->lastPercent) {
                $this->rate .= $this->piece;
            }
        }else{
            if ($this->percent != $this->lastPercent) {
                $this->rate .= $this->piece;
            }
        }

        if ($this->total < 100){
            $f = $this->total;
        }else{
            $f = 50;
        }
        printf("\r[%-".$f."s]%3d%%  %8d/%d", $this->rate, $this->percent, $this->current, $this->total);
    }

    public function finish()
    {
        $elapsedTime = round(microtime(true) - $this->startTime,2);
        printf("\n【已完成".date('Y-m-d H:i:s')."】总耗时：%0.2fs", $elapsedTime);
    }

    public function test()
    {
        $pb = new Pmgressbar();
        for ($i = 0; $i < 101; $i++) {
            usleep(intval(1e4));
            $pb->play($i);
        }
        $pb->finish();

    }
}