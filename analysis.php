<!DOCTYPE html>
<html>
    <head>
        <title>PHP MySQL Stored Procedure Demo 1</title>
        <link rel="stylesheet" href="css/table.css" type="text/css" />
    </head>
    <body>
        <?php
        require_once 'dbconfig.php';
        try {
	    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $sql = 'CALL calculate_scenario_close_open';
            $q = $pdo->query($sql); // call sp
            $q->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }
        ?>
        <table>
            <tr>
                <th>Rating</th>
                <th>Symbol</th>
                <th>Company Name</th>
            </tr>
            <?php while ($r = $q->fetch()): ?>
                <tr>
                    <td><?php echo number_format($r['bay']*100, 1) . '%' ?></td>
                    <td><?php echo $r['symbol'] ?></td>
                    <td><a href="historical.php?stock_id=<?php echo $r['stock_id'] ?>"><?php echo $r['company_name'] ?></a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </body>
</html>
