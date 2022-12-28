<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class Table extends Component
{
    public array $headers;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($headers)
    {
        $this->headers = $this->formatHeaders($headers);
    }

    private function formatHeaders(array $headers) :array
    {
        return array_map(function($header){
            $name = is_array($header) ? $header['name'] : $header;
            $class = $header['class'] ?? '';
            $width = $header['width'] ?? '';

            return [
                'name' => $name,
                'classes' => $class,
                'width' => $width
            ];
        }, $headers);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.table');
    }
}