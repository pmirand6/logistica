<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Node\Node;
use App\Repositories\Node\NodeRepositoryInterface;
use Illuminate\Http\Request;


class NodeController extends Controller
{
    protected $nodeInterface;

    public function __construct(NodeRepositoryInterface $nodeInterface)
    {
        $this->nodeInterface = $nodeInterface;
    }

    public function index()
    {
        return $this->nodeInterface->getAllActiveNodes();
    }

    public function show($nodeId)
    {
        return $this->nodeInterface->getNodeById($nodeId);
    }

    public function createNode(Request $request)
    {
        //TODO CREAR VALIDACION
        return $this->nodeInterface->createNode($request);
    }

    public function updateNode(Request $request, $nodeId)
    {
        //TODO CREAR VALIDACION
        return $this->nodeInterface->updateNode($request, $nodeId);
    }

    public function getNearest(Request $request){
        return $this->nodeInterface->getNearest($request);
    }

    public function getDistributorsFromNode($nodeId, $deliveryType)
    {
        return $this->nodeInterface->getDistributorsFromNode($nodeId, $deliveryType);
    }

}
