<div class="container-fluid pt-3 pb-3">
    <div class="row px-xl-5">

        <div class="col-lg-12 text-left">
            <form action="{{ route('android.busqueda', auth()->id()) }}" method="get" onsubmit="preSubmit()">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar productos" name="buscar" required>
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
