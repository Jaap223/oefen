<?php
require_once 'data/db.php';
require_once 'head/head.php';

class UpdateAuto extends Database
{

    //Updaten
    public function updateAuto($car_id, $brand, $model, $price)
    {
        try {
            $sql = "UPDATE cars SET car_id = :car_id, brand = :brand, model = :model, price = :price WHERE car_id = :car_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':car_id', $car_id, PDO::PARAM_INT);
            $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
            $stmt->bindParam(':model', $model, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {

            return $e->getMessage();
        }
    }



    // public function updateAuto($car_id, $brand, $model, $price) 
    // {
    //     try {
    //         $sql = "UPDATE cars SET car_id = :car_id, brand = :brand =, model =:model, price = :price WHERE car_id = :car_id";
    //         $stmt = $this->connect()->prepare($sql);
    //         $stmt->bindParam(':car_id', $car_id, PDO::PARAM_INT);
    //         $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
    //         $stmt->bindParam(':model', $model, PDO::PARAM_STR);
    //         $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    //         $stmt->execute();
    //     } catch (PDOException $e) {


    //         return $e->getMessage();
    //     }
    // }


    public function deleteAuto($car_id)
    {
        try {
            $sql = "DELETE FROM cars WHERE car_id = :car_id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':car_id', $car_id, PDO::PARAM_INT);
            $stmt->execute();

            $rowCount = $stmt->rowCount();

            return $rowCount;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function fetchAll($sql)
    {
        try {
            $sql = "SELECT * FROM updates";
            $stmt = $this->connect()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

// class aanroepen en bericht
$updaten = new UpdateAuto();
$updateMessage = '';
$deleteMessage = '';


//logica om de functie te laten werken door de parameters uit de database te halen en vervolgens het resultaat te updaten
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['updateAuto'])) {

        $car_id = $_POST['car_id'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $price = $_POST['price'];

        $result = $updaten->updateAuto($car_id, $brand, $model, $price);

        if ($result > 0) {
            $updateMessage = 'Auto geupdate';
        } else {
            $updateMessage = 'Error updating auto';
        }
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'deleteAuto') {
        $delete = new UpdateAuto();
        $delete->deleteAuto($_POST['car_id']);
        $deleteMessage = 'Auto verwijderd!';
        exit();
    }
}




?>

<section class="formR">
    <h1>Auto updaten</h1>


    <?php
    // Fetch the current values from the database based on the given car_id
    if (isset($_POST['car_id'])) {
        $currentValues = $updaten->fetchAll("SELECT * FROM cars WHERE car_id = " . $_POST['car_id']);
        if (!empty($currentValues)) {
            $currentValues = $currentValues[0]; 
        } else {
            $currentValues = [];
        }
    } else {
        $currentValues = [];
    }
    ?>


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
                    <label for="price">Price:</label>
                </td>
                <td>
                    <input type="number" id="price" name="price" required>
                </td>
            </tr>
        </table>

        <div>
            <button type="submit" name="updateAuto">Update de auto</button>
        </div>
    </form>

    <?php echo $updateMessage; ?>


    <?php echo $deleteMessage; ?>

</section>