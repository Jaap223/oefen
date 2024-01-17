<?php
require_once 'head/head.php';
require_once 'data/db.php';

class Auto extends Database
{


    //Functie om een auto toe te voegen in de database tabel
    public function addAuto($car_id, $brand, $model, $price)
    {
        try {
            $sql = "INSERT INTO cars (car_id, brand, model, price) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(1, $car_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $brand, PDO::PARAM_STR);
            $stmt->bindParam(3, $model, PDO::PARAM_STR);
            $stmt->bindParam(4, $price, PDO::PARAM_INT);

            $stmt->execute();
            $rowCount = $stmt->rowCount();
            return $rowCount;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


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
    //functie om een auto id te verwijderen in de database
    public function delete($car_id)
    {
        try {
            $sql  = "DELETE FROM cars WHERE car_id = :car_id LIMIT 1";
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
            $stmt = $this->connect()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

$invoeren = new Auto();
$up = new Auto();
$insertMessage = '';
$deleteMessage = '';
$uMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //om de functie uit te voeren
    if (isset($_POST['addAuto'])) {
        $car_id = $_POST['car_id'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $price = $_POST['price'];

        $result = $invoeren->addAuto($car_id, $brand, $model, $price);

        if ($result > 0) {
            $insertMessage = 'Auto toegevoegd!';
        } else {
            $insertMessage = 'fout bij het toevoegen van een auto';
        }
    }

    // Om de functie te verwijderen 

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $delete = new Auto();
        $delete->delete($_POST['car_id']);
        $deleteMessage = 'Auto verwijderd!';
    }



    if (isset($_POST['updateAuto'])) {

        $car_id = $_POST['car_id'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $price = $_POST['price'];

        $result = $up->updateAuto($car_id, $brand, $model, $price);

        if ($result > 0) {
            $uMessage = "Auto geupdated";
        } else {
            $uMessage = "Niet geupdated";
        }
    }
}
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
                    <label for="price">Price:</label>
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

    <?php echo $insertMessage; ?>

    <?php echo $deleteMessage; ?>
</section>
<br>

<section class="formR">
    <h1>Auto updaten</h1>
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

    <?php echo $uMessage; ?>
    <?php echo $deleteMessage; ?>
   
</section>
<h2>Auto's</h2>
<table class="tab2">
    <tr>
        <th>Car ID</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php
    $cars = $invoeren->fetchAll("SELECT * FROM cars");

    foreach ($cars as $car) {
        echo "<tr>";
        echo "<td>{$car['car_id']}</td>";
        echo "<td>{$car['brand']}</td>";
        echo "<td>{$car['model']}</td>";
        echo "<td>{$car['price']}</td>";
        echo "<td>
                    <form method='post' action='{$_SERVER['PHP_SELF']}'>
                        <input type='hidden' name='car_id' value='{$car['car_id']}'>
                        <input type='hidden' name='action' value='delete'>
                        <button type='submit'>Delete</button>
                    </form>
                  </td>";
        echo "</tr>";
    }
    ?>
</table>