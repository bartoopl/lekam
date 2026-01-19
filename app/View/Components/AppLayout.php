<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Try to get header slot - slots are available as properties if defined
        $header = null;
        if (property_exists($this, 'header')) {
            $header = $this->header;
        } elseif (method_exists($this, 'slot')) {
            try {
                $header = $this->slot('header');
            } catch (\Exception $e) {
                // Slot doesn't exist
            }
        }

        return view('layouts.app', [
            'header' => $header,
        ]);
    }
}
