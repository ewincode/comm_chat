<?php

class Chart {
    private $width;
    private $height;
    private $title;
    private $data = [];

    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function addData($values, $label) {
        $this->data[] = ['values' => $values, 'label' => $label];
    }

    public function draw() {
        $html = '<canvas id="myChart" width="' . $this->width . '" height="' . $this->height . '"></canvas>';
        $html .= '<script>';
        $html .= 'var ctx = document.getElementById("myChart").getContext("2d");';
        $html .= 'var myChart = new Chart(ctx, {';
        $html .= 'type: "line",';
        $html .= 'data: {';
        $html .= 'labels: ["January", "February", "March", "April", "May"],';
        $html .= 'datasets: [';

        foreach ($this->data as $dataset) {
            $html .= '{';
            $html .= 'label: "' . $dataset['label'] . '",';
            $html .= 'data: [' . implode(',', $dataset['values']) . '],';
            $html .= '},';
        }

        $html .= ']},';
        $html .= 'options: {';
        $html .= 'title: {';
        $html .= 'display: true,';
        $html .= 'text: "' . $this->title . '"';
        $html .= '}}});';
        $html .= '</script>';

        return $html;
    }
}
?>
