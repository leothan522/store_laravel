<?php

namespace App\Http\Livewire;

use App\Models\Carrito;
use App\Models\Cliente;
use App\Models\Delivery;
use App\Models\Empresa;
use App\Models\Parametro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use function PHPUnit\Framework\isEmpty;

class UsuariosComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'confirmed',
    ];

    public $name, $email, $password, $role, $busqueda;
    public $user_id, $user_name, $user_email, $user_password, $user_role, $user_role_id, $user_estatus, $user_fecha, $user_permisos,
        $user_path, $user_empresa, $listaEmpresas, $selectEmpresa;

    public function mount(Request $request)
    {
        if (!is_null($request->usuario)){
            $this->busqueda = $request->usuario;
        }
    }

    public function render()
    {
        $users = User::buscar($this->busqueda)
            ->orderBy('role', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate(30);
        if ($users->isEmpty()){
            verSweetAlert2("Busqueda sin resultados", 'toast', null, 'error');
        }
        $roles = Parametro::where('tabla_id', '-1')->get();
        return view('livewire.usuarios-component')
            ->with('users', $users)
            ->with('list_roles', $roles);
    }

    public function generarClave()
    {
        $this->password = Str::random(8);
    }

    public function limpiar()
    {
        $this->user_id = null;
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->role = null;
        $this->user_id = null;
        $this->user_name = null;
        $this->user_email = null;
        $this->user_password = null;
        $this->user_role = null;
        $this->user_role_id = null;
        $this->user_estatus = null;
        $this->user_fecha = null;
        $this->user_permisos = null;
        $this->user_path = null;
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:4',
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => 'required|min:8',
            'role' => 'required'
        ];

        $this->validate($rules);
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        if ($this->role > 1){
            $user->role = 2;
            $user->roles_id = $this->role;
        }else{
            $user->role = $this->role;
            $user->roles_id = null;
        }

        $user->password = Hash::make($this->password);

        $role = Parametro::where('tabla_id', '-1')->where('id', $this->role)->first();
        if ($role){
            $user->permisos = $role->valor;
        }

        $user->save();
        $this->alert(
            'success',
            'Usuario Creado'
        );
        $this->limpiar();
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->user_id = $user->id;
        $this->user_name = $user->name;
        $this->user_email = $user->email;
        if ($user->roles_id)
        {
            $this->user_role = $user->roles_id;
        }else{
            $this->user_role = $user->role;
        }
        $this->user_estatus = $user->estatus;
        $this->user_fecha = $user->created_at;
        $this->user_path = $user->profile_photo_path;
        $this->user_empresa = $user->empresas_id;

        //dd($user->roles_id);

        $empresas = Empresa::orderBy('nombre', 'ASC')->get();
        if ($empresas->isNotEmpty()){
            $this->listaEmpresas = $empresas;
        }else{
            $this->listaEmpresas = null;
        }

    }

    public function update($id)
    {
        $rules = [
            'user_name' => 'required|min:4',
            'user_email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'user_role' => 'required'
        ];
        $this->validate($rules);
        $user = User::find($id);
        $user->name = $this->user_name;
        $user->email = $this->user_email;
        //$user->role = $this->user_role;
        if ($this->user_role > 1){
            $user->role = 2;
            $user->roles_id = $this->user_role;
        }else{
            $user->role = $this->user_role;
            $user->roles_id = null;
        }
        if ($this->user_empresa == 0){
            $user->empresas_id = null;
        }else{
            $user->empresas_id = $this->user_empresa;
        }

        $role = Parametro::where('tabla_id', '-1')->where('id', $user->roles_id)->first();
        if ($role){
            $user->permisos = $role->valor;
        }

        $user->update();

        $this->edit($user->id);

        $this->alert(
            'success',
            'Usuario Actualizado'
        );

    }

    public function cambiarEstatus($id)
    {
        $user = User::find($id);

        if ($user->estatus){
            $user->estatus = 0;
            $texto = "Usuario Suspendido";
        }else{
            $user->estatus = 1;
            $texto = "Usuario Activado";
        }

        $user->update();
        $this->user_estatus = $user->estatus;
        $this->alert(
            'success',
            $texto
        );
    }

    public function restablecerClave($id)
    {
        if (!$this->user_password){
            $clave = Str::random(8);
        }else{
            $clave = $this->user_password;
        }
        $user = User::find($id);
        $user->password = Hash::make($clave);
        $user->update();
        $this->user_password = $clave;
        $this->alert(
            'success',
            'Contraseña Restablecida'
        );
    }

    public function edit_permisos($id)
    {
        $user = User::find($id);
        $this->user_id = $user->id;
        $this->user_name = $user->name;
        $this->user_permisos = $user->permisos;
    }

    public function update_permisos($id, $permiso)
    {
        $permisos = [];
        $user = User::find($id);
        if (!leerJson($user->permisos, $permiso)){
            $permisos = json_decode($user->permisos, true);
            $permisos[$permiso] = true;
            $permisos = json_encode($permisos);
            $this->alert(
                'success',
                'Permiso Agregado'
            );
        }else{
            $permisos = json_decode($user->permisos, true);
            unset($permisos[$permiso]);
            $permisos = json_encode($permisos);
            $this->alert(
                'success',
                'Permiso Eliminado'
            );
        }

        $user->permisos = $permisos;
        $user->update();

    }

    public function destroy($id)
    {
        $this->user_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmed',
        ]);

    }


    public function confirmed()
    {
        // Example code inside confirmed callback
        $user = User::find($this->user_id);

        $carrito = Carrito::where('users_id', $user->id)->first();
        $delivery = Delivery::where('users_id', $user->id)->first();
        $clientes = Cliente::where('users_id')->first();

        if ($carrito || $delivery || $clientes){

            $this->alert('warning', '¡No se puede Borrar!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'El registro que intenta borrar ya se encuentra vinculado con otros procesos.',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'OK',
            ]);

        }else{

            $user->delete();
            $this->user_id = null;
            $this->alert(
                'success',
                'Usuario Eliminado'
            );

        }

    }


}
