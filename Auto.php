<?php 
require_once 'head/head.php';
require_once 'data/db.php';



//Verwijder een object



class Auto extends Database {


    public function addAuto($car_id, $brand, $model, $price)
    {

        try {
            $sql = "INSERT INTO cars (car_id, brand, model, price) VALUES (?, ?, ?, ? ,?)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(1, $car_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $brand, PDO::PARAM_STR);
            $stmt->bindParam(3, $model, PDO::PARAM_STR);
            $stmt->bindParam(4, $price,PDO::PARAM_INT);

            $stmt->execute();
            $rowCount = $stmt->rowCount();
            return $rowCount;
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete'){
    $verwijderObj->delete($_POST['car_id']);
    exit();
}

$delete = new Auto();



?>



<section class="formR">
    <h1>Auto invoeren</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <td>
                    <label for="car_id">Car_id:</label>
                </td>
                <td>
                    <input type="number" id="car_id" name="car_id" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="brand">Brand:</label>
                </td>
                <td>
                    <input type="text" id="brand" name="brand" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="model">Model:</label>
                </td>
                <td>
                    <input type="text" id="model" name="model" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Price">Price:</label>
                </td>
                <td>
                    <input type="number" id="price" name="price" required>
                </td>
            </tr>
       
        </table>

        <div>
            <button type="submit" name="addAuto">Insert Auto</button>
        </div>
    </form>