<?php 
require('inc/db_config.php'); // Including the database configuration file
require('inc/essentials.php'); 
adminLogin();

// Fetch settings data from the database
$settingsData = fetchDataFromDatabase($conn, 'settings');

// Check if the form is submitted for updating settings
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_settings'])) {
        $siteTitle = $_POST['site_title'];
        $aboutUs = $_POST['site_about'];
        
        $updateResult = updateSettings($conn, $siteTitle, $aboutUs);
        if ($updateResult === true) {
            // Refresh the page after successful update
            header("Location: setting.php");
            exit();
        } else {
            echo "Error: " . $updateResult;
        }
    } elseif (isset($_POST['update_shutdown'])) {
        $shutdown = isset($_POST['shutdown']) ? 1 : 0;
        
        $query = "UPDATE settings SET shutdown = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $shutdown);

        if ($stmt->execute()) {
            // Refresh the page after successful update
            header("Location: setting.php");
            exit();
        } else {
            echo "Error: Failed to update shutdown status!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Settings</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-white">
    
    <?php require('inc/header.php'); ?>
    
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3>SETTINGS</h3>

                <!-- general settings section -->
                <div class="card border-0 shadow mt-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                                <i class="bi bi-pencil-square"></i>Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                        <p class="card-text"><?php echo $settingsData[0]['site_title']; ?></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
                        <p class="card-text"><?php echo $settingsData[0]['site_about']; ?></p>
                    </div>
                </div>

                <!-- general settings modal -->
                <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title">General Settings</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Site Title</label>
                                        <input type="text" name="site_title" class="form-control shadow-none" value="<?php echo $settingsData[0]['site_title']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">About us</label>
                                        <textarea name="site_about" class="form-control shadow-none" rows="6"><?php echo $settingsData[0]['site_about']; ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="resetForm()">CANCEL</button>
                                    <button type="submit" name="update_settings" class="btn custom-bg text-white shadow-none" onclick="showAlert('success', 'Changes Saved !')">SUBMIT</button>
                                </div>
                            </div>                               
                        </form>
                    </div>
                </div>

                <!-- Shutdown section -->
                <div class="card border-0 shadow mt-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown Website</h5>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="form-check form-switch">
                                    <input name="shutdown" class="form-check-input" type="checkbox" id="shutdown-toggle" onchange="this.form.submit()" <?php echo ($settingsData[0]['shutdown'] == 1) ? 'checked' : ''; ?>>
                                    <input type="hidden" name="update_shutdown" value="1">
                                </div>
                            </form>
                        </div>
                        <p class="card-text">No customers will be allowed to book hotel rooms when shutdown mode is turned on.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script>
        const originalSiteTitle = "<?php echo addslashes($settingsData[0]['site_title']); ?>";
        const originalSiteAbout = "<?php echo addslashes($settingsData[0]['site_about']); ?>";

        function resetForm() {
            document.getElementById('site_title').value = originalSiteTitle;
            document.getElementById('site_about').value = originalSiteAbout;
        }

        // Ensure modal form resets to initial values when opened
        var myModal = new bootstrap.Modal(document.getElementById('general-s'));
        document.getElementById('general-s').addEventListener('hidden.bs.modal', resetForm);

        function showAlert(type, msg) {
            let bs_class  = (type == 'success') ? 'alert-success' : 'alert-danger';
            let element = document.createElement('div');
            element.innerHTML = `
                <div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert">
                    <strong class="me-3">${msg}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.body.appendChild(element);
        }

    </script>
</body>
</html>
