<?php


namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::select('id', 'nombre', 'domicilio', 'ciudad', 'cp', 'telefono', 'email')->get();
        return view('cliente.index', ['clientes' => $this->cargarDT($clientes)]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cliente.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'domicilio' => 'required',
            'ciudad' => 'required',
            'cp' => 'required|digits:5',
            'telefono' => 'required|digits:10',
            'email' => 'required',
            'password' => 'required',
        ]);
        $cliente = new Cliente();
        $cliente->nombre = $request->input('nombre');
        $cliente->domicilio = $request->input('domicilio');
        $cliente->ciudad = $request->input('ciudad');
        $cliente->cp = $request->input('cp');
        $cliente->telefono = $request->input('telefono');
        $cliente->email = $request->input('email');
        $cliente->password = bcrypt($request->input('password'));
        $cliente->save();
        return redirect()->route('cliente.login')->with('success', 'Se ah registrado usuario de manera correcta');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // esta funcion nos permitira realizar cambios en los datos del cliente, nos traera los datos del cliente y los mostrara en el formulario de edicion
        $cliente = Cliente::findorFail($id);
        return view('cliente.edit',  array(
            'cliente' => $cliente
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Guardaremos los cambios realizados en el formulario de edicion
        $this->validate($request, [
            'nombre' => 'required',
            'domicilio' => 'required',
            'ciudad' => 'required',
            'cp' => 'required|digits:5',
            'telefono' => 'required|digits:10',
            'email' => 'required',
        ]);
        $cliente = Cliente::findorFail($id);
        $cliente->nombre = $request->input('nombre');
        $cliente->domicilio = $request->input('domicilio');
        $cliente->ciudad = $request->input('ciudad');
        $cliente->cp = $request->input('cp');
        $cliente->telefono = $request->input('telefono');
        $cliente->email = $request->input('email');
        $cliente->password = bcrypt($request->input('password'));
        $cliente->save();
        return redirect() -> route('cliente.create', $id)->with('susccess', 'Cliente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteCliente(string $id)
    {
        //Eliminaremos el cliente seleccionado de la base de datos
        $cliente = Cliente::findorFail($id);
        $cliente->delete();
        return redirect()->route('cliente.index')->with('success', 'Cliente eliminado correctamente');
    }

    private function cargarDT($consulta)
    {
        $clientes = [];

        foreach ($consulta as $cliente) {
            $clientes[] = [
                'id' => $cliente->id,
                'nombre' => $cliente->nombre,
                'domicilio' => $cliente->domicilio,
                'ciudad' => $cliente->ciudad,
                'cp' => $cliente->cp,
                'telefono' => $cliente->telefono,
                'email' => $cliente->email,
            ];
        }

        return $clientes;
    }


    #Funciones de ecommerce, puede que se llegue a tomar algunas funciones sobre las que ya estaban, 
    #esto para poder ahorrar tiempo
    
    public function loginCliente()
    {
        return view('clientelogin.login');
    }

    
    public function registerCliente(){
        return view('clientelogin.register');
    }
    
    public function Login(Request $request){

        $cliente = $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($cliente)){
            $request->session()->regenerate();
            return redirect()->intended('dashboardecommerce.index');
        }

        return back()->withErrors([
            'email' => 'Las credencias no coinciden, favor de verificar nuevamente'
        ])->onlyInput('email');
    }


}


