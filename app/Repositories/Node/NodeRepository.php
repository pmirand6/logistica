<?php


namespace App\Repositories\Node;

use App\Manager\DateManager;
use App\Manager\ResponseManager;
use App\Models\Node\Node;
use App\Models\Vehicle\Vehicle;
use App\Resources\Node\NodeCollection;
use App\Resources\Node\NodeResource;
use App\Resources\Vehicle\VehicleResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class NodeRepository extends ResponseManager implements NodeRepositoryInterface
{

    public function getAllActiveNodes()
    {
        try {
            //TODO CREAR VALIDACIONES Y VERIFICAR QUE SEAN LOS NODES ACTIVOS
            return NodeCollection::collection((new Node)->paginate());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getNodeById($id)
    {
        try {
            //TODO CREAR VALIDACIONES
            $node = (new Node)->findOrFail($id);
            return new NodeResource($node);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteNode($id)
    {
        // TODO: Implement deleteNode() method.
    }

    public function updateNode($request, $nodeId)
    {
        try {
            $node = (new Node)->find($nodeId);
            if (!$node) {
                throw new Exception("Node not found.");

            }

            //TODO: Agregar validaciones.
            $node->name = $request->name;
            $node->businessName = $request->business_name;
            $node->geo = $request->geo;
            $node->latitude = $request->longitude;
            $node->longitude = $request->latitude;
            $node->streetName = $request->street_name;
            $node->floor = $request->random_number;
            $node->departmentNumber = $request->department_number;
            $node->logo = $request->logo;
            $node->phoneNumber = $request->phone_number;
            $node->email = $request->email;
            $node->active = $request->active;
            $node->localitiesId = $request->localities_id;
            $node->workHourStart = $request->work_hour_start;
            $node->workHourEnd = $request->work_hour_end;
            $node->workDays = $request->work_days;

            $node->save();

            return new NodeResource($node);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function createNode($request)
    {
        try {
            $node = new Node;
            $node->name = $request->name;
            $node->businessName = $request->business_name;
            $node->geo = $request->geo;
            $node->latitude = $request->longitude;
            $node->longitude = $request->latitude;
            $node->streetName = $request->street_name;
            $node->floor = $request->random_number;
            $node->departmentNumber = $request->department_number;
            $node->logo = $request->logo;
            $node->phoneNumber = $request->phone_number;
            $node->email = $request->email;
            $node->active = $request->active;
            $node->localitiesId = $request->localities_id;
            $node->workHourStart = $request->work_hour_start;
            $node->workHourEnd = $request->work_hour_end;
            $node->workDays = $request->work_days;

            $node->save();

            return new NodeResource($node);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getNearest($request)
    {
        try {
            return DB::select('CALL SP_NODOS_CERCANOS(?, ?, ?, ?)', array($request->latitude, $request->longitude, 3000, 15));
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param $nodeId
     * @param $deliveryType
     * @return mixed
     * @throws Exception
     *
     * Se evalua si el vehiculo atiende el día en el que se realiza el request
     * Si el delivery type es el que se solicita en el request
     * Si el chofer esta activo
     * Si el vehiculo esta activo
     *
     */
    public function getDistributorsFromNode($nodeId, $deliveryType)
    {
        try {
            $vehicle = (new Node)->where('nodeId', $nodeId)
                ->with(['vehicle' => function ($q) use ($deliveryType) {
                    $q->whereHas('deliveryType', function ($d) use ($deliveryType) {
                        $d->where('name', $deliveryType);
                    })
                        ->with(['driver' => function ($v) {
                            $v->where('active', true)
                                ->select('driverId', 'lastName', 'name', 'active');
                        }])
                        ->where('deliveryDays', 'like', '%' . (new DateManager())->getTodayName() . '%')
                        ->where('active', true);
                }])
                ->firstOrFail();

            return $vehicle['vehicle'];


        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }

    }
}
