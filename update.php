<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the app_usage id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $device_name = isset($_POST['device_name']) ? $_POST['device_name'] : '';
        $group_name= isset($_POST['group_name']) ? $_POST['group_name'] : '';
        $group_parent = isset($_POST['group_parent']) ? $_POST['group_parent'] : '';
        $application= isset($_POST['application']) ? $_POST['application'] : '';
        $duration = isset($_POST['duration']) ? $_POST['duration'] : 
        $mobiledata = isset($_POST['mobiledata']) ? $_POST['mobiledata'] : '';
        $wifidata= isset($_POST['wifidata']) ? $_POST['wifidata'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE app_usage SET ID = ?, device_name = ?, group_name = ?, group_parent = ?, app = ?, duration = ?, mobiledata = ?, wifidata = ? WHERE ID = ?');
        $stmt->execute([$ID, $device_name, $group_name, $group_parent, $application,$duration,$mobiledata,$wifidata,$_GET['ID']]);
        $msg = 'Updated Successfully!';
    }
    // Get the app_usage from the app_usage table
    $stmt = $pdo->prepare('SELECT * FROM app_usage WHERE ID = ?');
    $stmt->execute([$_GET['id']]);
    $app_usage = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$app_usage) {
        exit('App Usage doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update Contact #<?=$app_usage['ID']?></h2>
    <form action="update.php?id=<?=$app_usage['ID']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Device Name</label>
        <input type="text" name="ID" placeholder="1" value="<?=$app_usage['ID']?>" id="ID">
        <input type="text" name="name" placeholder="" value="<?=$app_usage['Device_Name']?>" id="Device name">
        <label for="email">Group Name</label>
        <label for="phone">Group Parent</label>
        <input type="text" name="email"  value="<?=$app_usage['Group Name']?>" id="email">
        <input type="text" name="phone"  value="<?=$app_usage['Group Parent']?>" id="phone">
    <label for="email">Duration</label>
        <label for="phone">Application</label>
        <input type="text" name="email"  value="<?=$app_usage['Duration']?>" id="email">
        <input type="text" name="phone"  value="<?=$app_usage['Application']?>" id="phone">
        <label for="email">Mobile Data Used</label>
        <label for="phone">Wifi Data Used</label>
        <input type="text" name="email"  value="<?=$app_usage['Mobile Data Used']?>" id="email">
        <input type="text" name="phone"  value="<?=$app_usage['Wifi Data Used']?>" id="phone">
        <input type="submit" value="Update Data">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
