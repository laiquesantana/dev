<?php

namespace App\Http\Controllers\API;

use App\Repositories\VendasRepository;
use App\Http\Controllers\Controller;
use dev\Dependencies\Adapters\Logger\MonologLogAdapter;
use dev\Modules\Vendas\Creation\UseCase;
use dev\Modules\Vendas\Generics\Entities\Vendas;
use Illuminate\Http\Request;
use dev\Modules\Vendas\Creation\Requests\Request as VendaRequest;

class FormularioVendasController extends Controller
{
    private VendasRepository $vendasRepository;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->vendasRepository = new VendasRepository();
    }

    public function index(Request $request)
    {
        return $this->vendasRepository->retornaTodasVendas();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'arquivo' => 'required',
        ]);
        $useCase = new UseCase(new VendasRepository(), new MonologLogAdapter());

        $venda = (new Vendas())
            ->setArquivo($request->input('arquivo'));
        $request = new VendaRequest($venda);

        $useCase->execute($request);

        return response(
            $useCase->getResponse()->getPresenter()->toArray(),
            $useCase->getResponse()->getStatus()->getCode()
        );
    }

    public function destroy(Request $request, int $id)
    {
        return $this->vendasRepository->deletarVenda($id);
    }
}
