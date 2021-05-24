<?php

namespace App\Exports;

use App\Formulario;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LevantamientoExport implements FromView
{


    private $id;
    private $form;

    public function __construct($form)
    {
        $this->form=$form;
    }

    /**
     * @inheritDoc
     */
    public function view(): View
    {


        $formulario = $this->form;

        return view('export.levantamiento', compact('formulario'));



        // TODO: Implement view() method.
    }
}
