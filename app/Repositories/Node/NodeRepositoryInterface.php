<?php


namespace App\Repositories\Node;


interface NodeRepositoryInterface
{
    public function getAllActiveNodes();

    public function getNodeById($nodeId);

    public function updateNode($request, $nodeId);

    public function createNode($request);

    public function getNearest($request);

    public function getDistributorsFromNode($nodeId, $deliveryType);

}
