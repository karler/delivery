<?PHP

use MongoDB\Collection;

    require_once __DIR__ . '/../config/database.php';

    class PedidoController {
        private $db;
        private $collection;

        public function __construct(){
            $database = new Database();
            $this->db = $database->getDatabase();
            $this->collection = $this->db->pedidos;
        }

        public function listarPedidos(){
            try{
                $pipeline = [
                    [
                        '$lookup' => [
                            'from' => 'clientes',
                            'localField' => 'id_cliente',
                            'foreignField' => '_id',
                            'as' => 'cliente_info'
                        ]
                    ],
                    [
                        '$unwind' => [
                            'path' => '$cliente_info',
                            'preserveNullAndEmptyArrays' => true
                        ]
                    ],
                    [
                        '$project' => [
                            '_id' => 1,
                            'total' => 1,
                            'estado' => 1,
                            'fecha' => 1,
                            'hora' => 1,
                            'estado_pago' => 1,
                            'cliente' => [
                                'nombre' => '$cliente_info.nombre',
                                'telefono' => '$cliente_info.telefono',
                                'correo' => '$cliente_info.correo'
                            ]
                        ]
                    ],
                    [
                        '$sort' => [
                            'fecha' => -1,
                            'hora' => -1
                        ]
                    ]
                        
                ];
                return iterator_to_array($this->collection->aggregate($pipeline));
            } catch (Exception $e){
                error_log("Error en ListarPedidos". $e->getMessage());
                return [];
            }
        }
    }
?>