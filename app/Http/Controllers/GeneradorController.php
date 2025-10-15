<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Proveedor;

class GeneradorController extends Controller
{
    public function printproveedor()
    {
        $proveedores = Proveedor::activos()->get();
        $pdf = Pdf::loadView('plantillaPDF.proveedorpdf', compact('proveedores'));
        return $pdf->download('proveedor.pdf');
    }

    #Funcion donde mostrara los campos de BD en una tabla
    public function proveedortable()
    {
        $proveedores = Proveedor::activos()->get();
        $pdf = Pdf::loadView('plantillaPDF.proveedorpdf', compact('proveedores'));
        return $pdf->download('proveedor.pdf');
    }


}
