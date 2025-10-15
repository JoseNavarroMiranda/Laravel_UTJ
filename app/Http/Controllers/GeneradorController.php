<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Proveedor;
use App\Models\Cliente;

class GeneradorController extends Controller
{

    // funciones para poder generar PDF de modelo de proveedor
    public function printproveedor()
    {
        $proveedores = Proveedor::activos()->get();
        $pdf = Pdf::loadView('plantillaPDF.proveedorpdf', compact('proveedores'));
        return $pdf->download('proveedor.pdf');
    }

    // funciones para poder generar PDF de modelo de cliente
    public function printcliente()
    {
        $clientes = Cliente::all();
        $pdf = Pdf::loadView('plantillaPDF.clientepdf', compact('clientes'));
        return $pdf->download('cliente.pdf');
    }



}
