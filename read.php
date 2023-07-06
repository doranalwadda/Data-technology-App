<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our app_usage table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM app_usage ORDER BY ID LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$app_usage = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of app_usage, this is so we can determine whether there should be a next and previous button
$num_app_usage = $pdo->query('SELECT COUNT(*) FROM app_usage')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Read app_usage</h2>
	<a href="create.php" class="create-contact">Add New</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Device Name</td>
                <td>Group Name</td>
                <td>Group Parent</td>
                <td>Application</td>
                <td>Duration</td>
                <td>Mobile Data Used</td>
                <td>Wifi Data Used</td>
                <td></td>

            </tr>
        </thead>   <?php   foreach ($app_usage as $app_usage): ?>

            <tr>
                <td><?=$app_usage['ID']?></td>
                <td><?=$app_usage['Device_Name']?></td>
                <td><?=$app_usage['Group Name']?></td>
                <td><?=$app_usage['Group Parent']?></td>
                <td><?=$app_usage['Application']?></td>
                <td><?=$app_usage['Duration']?></td>
                <td><?=$app_usage['Mobile Data Used']?></td>
                <td><?=$app_usage['Wifi Data Used']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$app_usage['ID']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$app_usage['ID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_app_usage): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
