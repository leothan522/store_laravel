<div class="p-3" xmlns:wire="http://www.w3.org/1999/xhtml">
    <h5>Roles de Usuarios</h5>
    <hr class="mb-2">
    {{--<p>Sidebar content</p>--}}

    <h6>Crear nuevo Rol</h6>
    <form id="from_rol">
    <div class="input-group input-group-sm">
        <input type="text" class="form-control" placeholder="nombre" id="nuevo_rol" data-roles="{{ $roles->count() + 1 }}">
        <span class="input-group-append">
            <button type="submit" class="btn btn-info btn-flat">
                <i class="fas fa-save"></i>
            </button>
          </span>
    </div>
    </form>
    <hr class="mb-2">

    <ul class="nav nav-pills flex-column">

        <li class="nav-item">
            <span class="text-small text-muted float-right">Roles Registrados</span>
        </li>
        <li class="dropdown-divider"></li>

    </ul>
    <div class="col-md-12 justify-content-center" style="height: 350px; overflow-y: scroll;" id="listar_roles">
        @if($roles->isNotEmpty())
            @foreach($roles as $parametro)
                <button type="button" class="btn btn-default btn-sm btn-block m-1"
                        data-toggle="modal" data-target="#modal-lg-permisos"
                        class="btn btn-info btn-sm"
                        onclick="precionarBoton({{ $parametro->id }})">
                    {{ ucwords($parametro->nombre) }}
                </button>
            @endforeach
        @endif
    </div>



    {{--<h6>titulo</h6>
    <div class="d-flex">
        <select class="custom-select mb-3 text-light border-0 bg-white">
            <option class="bg-primary">Primary</option>
            <option class="bg-secondary">Secondary</option>
            <option class="bg-info">Info</option>
            <option class="bg-success">Success</option>
            <option class="bg-danger">Danger</option>
            <option class="bg-indigo">Indigo</option>
            <option class="bg-purple">Purple</option>
            <option class="bg-pink">Pink</option>
            <option class="bg-navy">Navy</option>
            <option class="bg-lightblue">Lightblue</option>
            <option class="bg-teal">Teal</option>
            <option class="bg-cyan">Cyan</option>
            <option class="bg-dark">Dark</option>
            <option class="bg-gray-dark">Gray dark</option>
            <option class="bg-gray">Gray</option>
            <option class="bg-light">Light</option>
            <option class="bg-warning">Warning</option>
            <option class="bg-white">White</option>
            <option class="bg-orange">Orange</option>
        </select>
    </div>--}}

</div>

