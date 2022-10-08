<div class="table-responsive" xmlns:wire="http://www.w3.org/1999/xhtml">
    <table class="table table table-sm table-hover bg-light">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center"><i class="fas fa-cloud"></i></th>
            <th scope="col">Nombre</th>
            <th scope="col">Email</th>
            <th scope="col" class="text-center">Rol</th>
            <th scope="col" class="text-center">Estatus</th>
            <th scope="col" class="text-right">Registro</th>
            <th scope="col" style="width: 5%;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @if(!$users->isEmpty())
            @foreach($users as $user)
                <tr>
                    @if($user->role == 100 && auth()->user()->role != 100) @continue @endif
                    <th class="text-center">{!! iconoPlataforma($user->plataforma) !!}</th>
                    <td>{{ ucwords($user->name) }}</td>
                    <td>{{ strtolower($user->email) }}</td>
                    <td class="text-center">{{ role($user->role, $user->roles_id) }}</td>
                    <td class="text-center">
                        {!! estatusUsuario($user->estatus, true) !!}
                        <span class="text-sm"> ID: {{ $user->id }}</span>
                    </td>
                    <td class="text-right">{{ haceCuanto($user->created_at)  }}</td>
                    <td class="justify-content-end">
                        <div class="btn-group">
                            @if ((leerJson(Auth::user()->permisos, 'usuarios.edit') && $user->role != 100 && $user->role != 1) || $user->role != 100 && Auth::user()->role == 1 || Auth::user()->role == 100)
                                <button wire:click="edit({{ $user->id }})" data-toggle="modal" data-target="#modal-lg" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @else
                                <button class="btn btn-info btn-sm" disabled><i class="fas fa-edit"></i></button>
                            @endif
                            {{-- @if ((leerJson(Auth::user()->permisos, 'usuarios.permisos') || Auth::user()->role == 1 || Auth::user()->role == 100) && $user->role != 100)--}}
                            @if ((leerJson(Auth::user()->permisos, 'usuarios.permisos') && $user->role != 100 && $user->role != 1) || $user->role != 100 && Auth::user()->role == 1 || Auth::user()->role == 100)
                                <button wire:click="verPermisos({{ $user->id }}, 'users')" data-toggle="modal" data-target="#modal-lg-permisos" class="btn btn-info btn-sm">
                                    <i class="fas fa-user-cog"></i>
                                </button>
                            {{--@else
                                <button class="btn btn-info btn-sm" disabled><i class="fas fa-cogs"></i></button>--}}
                            @endif
                            {{--@if ((leerJson(Auth::user()->permisos, 'usuarios.destroy') || Auth::user()->role == 100 || Auth::user()->role == 1) && ($user->role != 100 && $user->id != Auth::user()->id))--}}
                            @if (((leerJson(Auth::user()->permisos, 'usuarios.destroy') && $user->role != 100 && $user->role != 1) || $user->role != 100 && Auth::user()->role == 1 || Auth::user()->role == 100) && $user->id != Auth::user()->id)

                                <button wire:click="destroyUser({{ $user->id }})" class="btn btn-info btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            @else
                                <button class="btn btn-info btn-sm" disabled><i class="fas fa-trash-alt"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr class="text-center">
                <td colspan="7">
                    <a href="{{ route('usuarios.index') }}">
                        <span>
                            Sin resultados para la busqueda <strong class="text-bold"> { <span class="text-danger">{{ $busqueda }}</span> }</strong>
                        </span>
                    </a>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
