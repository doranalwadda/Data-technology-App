
<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $device_name = isset($_POST['device_name']) ? $_POST['device_name'] : '';
    $group_name= isset($_POST['group_name']) ? $_POST['group_name'] : '';
    $group_parent = isset($_POST['group_parent']) ? $_POST['group_parent'] : '';
    $application= isset($_POST['application']) ? $_POST['application'] : '';
    $duration = isset($_POST['duration']) ? $_POST['duration'] : 
    $mobiledata = isset($_POST['mobiledata']) ? $_POST['mobiledata'] : '';
    $wifidata= isset($_POST['wifidata']) ? $_POST['wifidata'] : '';
    // Insert new record into the app_usage table
    $stmt = $pdo->prepare('INSERT INTO app_usage VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$ID, $device_name, $group_name, $group_parent, $application,$duration,$mobiledata,$wifidata]);
    // Output message,
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create App Usage Data</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Device Name</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="name" placeholder="ERR-NQN-AAAZW" id="name">
        <label for="email">Group Name</label>
        <label for="phone">Group Parent</label>
        <input type="text" name="email" placeholder="Gweri Hub" id="email">
        <input type="text" name="phone" placeholder="FORTPORTAL" id="phone">
        <label for="title">Application</label>
        <label for="created">Druation</label>
        <input type="text" name="title" placeholder="io.shoonya.shoonyadpc" id="title">
        <input type="text" name="Duration"  placeholder= "16.5 hour" id="duration">
        <label for="title">Mobile Data Used</label>
        <label for="created">Wifi Data Used</label>
        <input type="text" name="mobiledata" placeholder="" id="title">
        <input type="text" name="wifidata"  placeholder= "1.09 MiB" id="">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>