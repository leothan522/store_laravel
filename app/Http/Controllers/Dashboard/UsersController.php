<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UsersController extends Controller
{
    public function index()
    {
        return view('dashboard.usuarios_up.usuarios');
    }

    public function export($busqueda = null)
    {
        return Excel::download(new UsersExport($busqueda), "Usuarios_Registrados_".date('d-m-Y').".xlsx");
    }

    public function createPDF()
    {
        QrCode::generate(route('usuarios.pdf'), public_path().'/img/qrcodes/qrcode.svg');

        $users = User::all();

        $data = [
            'users' => $users,
            'img'   => public_path().'/img/qrcodes/qrcode.svg'
        ];

        $pdf = Pdf::loadView('dashboard.export.usuarios_registrados', $data);
        return $pdf->download('Usuarios.pdf');
    }

    /*public function vistaPDF()
    {
        $users = User::all();
        return view('dashboard.usuarios.pdf')
            ->with('users', $users);
    }*/

}
