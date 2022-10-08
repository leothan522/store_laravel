<?php

namespace App\Http\Livewire;

use App\Models\Parametro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UsuariosupComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tabla = "parametros";
    public $tabla_id, $tabla_nombre, $tabla_permisos;
    public $view = "create", $busqueda;
    public $name, $email, $password, $role;
    public $user_id, $user_name, $user_email, $user_password, $user_role, $user_role_id, $user_estatus, $user_fecha,
        $user_permisos, $user_path;

    protected $listeners = [
        'verPermisos',
        'storeRol',
        'postAdded',
        'confirmedRol',
        'confirmedUser'
    ];

    public function mount(Request $request)
    {
        if (!is_null($request->usuario)){
            $this->busqueda = $request->usuario;
        }
    }

    public function render()
    {
        $roles = Parametro::where('tabla_id', '-1')->get();
        $users = User::buscar($this->busqueda)
            ->orderBy('role', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate(30);
        return view('livewire.usuariosup-component')
            ->with('roles', $roles)
            ->with('users', $users);
    }

    public function limpiar()
    {
        $this->tabla_id = null;
        $this->tabla_nombre = null;
        $this->tabla_permisos = null;
        $this->view = "create";
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->role = null;
    }

    public function verPermisos($id, $tabla)
    {
        $this->limpiar();
        $this->tabla = $tabla;
        if ($this->tabla == "parametros"){
            $parametro = Parametro::find($id);
            if ($parametro) {
                $this->tabla_id = $parametro->id;
                $this->tabla_nombre = ucwords($parametro->nombre);
                $this->tabla_permisos = $parametro->valor;
            }
        }else{
            $usuario = User::find($id);
            $this->tabla_id = $usuario->id;
            $this->tabla_nombre = ucwords($usuario->name);
            $this->tabla_permisos = $usuario->permisos;
        }

    }

    public function updatePermisos($id, $permiso)
    {
        $permisos = [];

        if ($this->tabla == "parametros"){
            $tabla = Parametro::find($id);
            $tabla_permisos = $tabla->valor;
        }else{
            //usuarios
            $tabla = User::find($id);
            $tabla_permisos = $tabla->permisos;
        }

        if (!leerJson($tabla_permisos, $permiso)){
            $permisos = json_decode($tabla_permisos, true);
            $permisos[$permiso] = true;
            $permisos = json_encode($permisos);
            $this->alert(
                'success',
                'Permiso Agregado'
            );
        }else{
            $permisos = json_decode($tabla_permisos, true);
            unset($permisos[$permiso]);
            $permisos = json_encode($permisos);
            $this->alert(
                'success',
                'Permiso Eliminado'
            );
        }

        if ($this->tabla == "parametros"){
            $tabla->valor = $permisos;
        }else{
            $tabla->permisos = $permisos;
        }

        $tabla->update();
        $this->tabla_permisos = $permisos;
    }

    public function storeRol($nombre)
    {
        if (empty($nombre) || strlen($nombre) <= 3){
            $this->alert(
                'warning',
                'el campo nombre es requerido min 4 caracteres.'
            );
        }else{

            $parametro = Parametro::where('nombre', $nombre)->where('tabla_id', -1)->first();
            if ($parametro){
                $this->alert(
                    'error',
                    "el rol ${nombre} ya existe."
                );
            }else{

                $parametro = new Parametro();
                $parametro->nombre = $nombre;
                $parametro->tabla_id = -1;
                $parametro->save();
                $this->emit('postAdded', $parametro->id, ucwords($parametro->nombre));
                $this->alert(
                    'success',
                    'Parametro Creado.'
                );

            }

        }

    }

    public function updateRol()
    {
        if (empty($this->tabla_nombre) || strlen($this->tabla_nombre) <= 3){
            $this->alert(
                'warning',
                'el campo nombre es requerido min 4 caracteres.'
            );
        }else{
            $existe = Parametro::where('nombre', $this->tabla_nombre)->where('tabla_id', -1)->first();
            if ($existe){
                $this->alert(
                    'error',
                    "el rol $this->tabla_nombre ya existe."
                );
            }else{
                $parametro = Parametro::find($this->tabla_id);
                $parametro->nombre = $this->tabla_nombre;
                $parametro->update();
            }
        }
        $this->verPermisos($parametro->id, "parametros");
        $this->alert(
            'success',
            'Cambios Guardados.'
        );
    }

    public function destroyRol($id)
    {
        $this->tabla_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedRol',
        ]);
    }

    public function confirmedRol()
    {
        // Example code inside confirmed callback
        $usuarios = User::where('roles_id', $this->tabla_id)->first();
        if ($usuarios){

            $this->alert('warning', '¡No se puede Borrar!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'El registro que intenta borrar ya se encuentra vinculado con otros procesos.',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'OK',
            ]);

        }else {
            $parametro = Parametro::find($this->tabla_id);
            $parametro->delete();
            $this->limpiar();
            $this->alert(
                'success',
                'Parametro Eliminado'
            );
        }
    }

    public function updateRolUsuarios()
    {
        $usuarios = User::where('roles_id', $this->tabla_id)->get();
        foreach ($usuarios as $user){
            $usuario = User::find($user->id);
            $usuario->permisos = $this->tabla_permisos;
            $usuario->update();
            $this->alert(
                'success',
                'Usuarios Actualizados'
            );
        }
    }

    public function postAdded()
    {
        //rol nuevo
    }

    public function generarClave()
    {
        $this->password = Str::random(8);
    }

    public function rules()
    {
        return [
            'name'      =>  'required|min:4',
            'email'     =>  ['required', 'email', Rule::unique('users')->ignore($this->tabla_id)],
            'password'  =>  'required|min:8',
            'role'      =>  'required'
        ];
    }

    public function storeUsuario()
    {
        $this->validate($this->rules());
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

    public function destroyUser($id)
    {
        $this->tabla_id = $id;
        $this->confirm('¿Estas seguro?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' =>  '¡Sí, bórralo!',
            'text' =>  '¡No podrás revertir esto!',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmedUser',
        ]);

    }


    public function confirmedUser()
    {
        // Example code inside confirmed callback
        $user = User::find($this->tabla_id);

        if (false){

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
            $this->limpiar();
            $this->alert(
                'success',
                'Usuario Eliminado.'
            );

        }

    }
}
