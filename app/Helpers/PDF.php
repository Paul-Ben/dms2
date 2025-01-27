<?php

namespace app\Helpers;

use setasign\Fpdi\Fpdi;

class PDF extends Fpdi
{
    protected $angle = 0;
    protected $extgstates = [];

    // Add a rotation method
    public function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) {
            $x = $this->x;
        }
        if ($y == -1) {
            $y = $this->y;
        }
        if ($this->angle != 0) {
            $this->_out('Q');
        }
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.3F %.3F %.3F %.3F %.3F %.3F cm 1 0 0 1 %.3F %.3F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    // Add transparency support
    public function SetAlpha($alpha, $bm = 'Normal')
    {
        // Transparency using blend modes
        if ($alpha < 0 || $alpha > 1) {
            $this->Error('Alpha value out of range: 0 <= alpha <= 1');
        }
        $gs = $this->AddExtGState(['ca' => $alpha, 'CA' => $alpha, 'BM' => '/' . $bm]);
        $this->SetExtGState($gs);
    }

    protected function AddExtGState($parms)
    {
        $n = count($this->extgstates) + 1;
        $this->extgstates[$n] = $parms;
        return $n;
    }

    protected function SetExtGState($gs)
    {
        $this->_out(sprintf('/GS%d gs', $gs));
    }
    
    public function CircularText($centerX, $centerY, $radius, $text, $startAngle = 0)
    {
        $textLength = strlen($text);
        $angleStep = 360 / $textLength; // Angle between each character

        $this->SetFont('Arial', '', 12); // Set font style and size
        for ($i = 0; $i < $textLength; $i++) {
            $angle = $startAngle + ($i * $angleStep); // Calculate the angle for the character
            $char = $text[$i];

            // Convert angle to radians for trigonometric functions
            $angleRad = deg2rad($angle);

            // Calculate character position
            $x = $centerX + $radius * cos($angleRad);
            $y = $centerY + $radius * sin($angleRad);

            // Rotate character
            $this->Rotate($angle + 90, $x, $y);
            $this->Text($x, $y, $char);
            $this->Rotate(0); // Reset rotation
        }
    }
}
