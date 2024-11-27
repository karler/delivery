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
            
        }
    }
?>