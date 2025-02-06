<?php

namespace App\View\Components\Sections;

use Illuminate\View\Component;

class ServiceCard extends Component
{
    public $title;
    public $description;
    public $icon;

    public function __construct($title, $description, $icon)
    {
        $this->title = $title;
        $this->description = $description;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.sections.service-card');
    }
}
