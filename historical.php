<!DOCTYPE html>
<html>
    <head>
        <title>Historical</title>
        <link rel="stylesheet" href="css/table.css" type="text/css" />
    </head>
    <body>
        <?php
        require_once 'dbconfig.php';
        try {
	    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);


		$sql = 'select symbol, company_name from stock where stock_id=:stock_id';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
		    ':stock_id' => $_GET['stock_id']
		));
		$name_sym = $stmt->fetch();

            $sql = 'CALL get_company_scenario_close_open(' . $_GET['stock_id'] . ')';
            $q = $pdo->query($sql); // call sp
            $q->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }
        ?>
	<h1><?php echo $name_sym['company_name'] . ' (' . $name_sym['symbol'] . ')' ?></h1>
        <table>
            <tr>
                <th>Release Date</th>
                <th>Prior Close</th>
                <th>After Open</th>
                <th>Percent Change</th>
            </tr>
            <?php while ($r = $q->fetch()): ?>
                <tr>
                    <td><?php echo $r['release_date'] ?></td>
                    <td><?php echo $r['close'] ?></td>
                    <td><?php echo $r['open'] ?></td>
                    <td><?php echo number_format($r['percent']*100, 1) . '%' ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </body>
</html>
