<?php
require 'socreg/config.php';
// Handle add award
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_award'])) {
    $awardName = $_POST['award_name'];
    $categoryID = $_POST['category_id'];
    $description = $_POST['description'];

    $sql = "INSERT INTO awards (AwardName, CategoryID, Description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $awardName, $categoryID, $description);

    if ($stmt->execute()) {
        header("Location: ?page=awards&success=add");
        exit();
    } else {
        $error = "Error adding award: " . $conn->error;
    }
}

// Handle update award
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_award'])) {
    $awardID = $_POST['award_id'];
    $awardName = $_POST['award_name'];
    $categoryID = $_POST['category_id'];
    $description = $_POST['description'];

    $sql = "UPDATE awards SET AwardName = ?, CategoryID = ?, Description = ? WHERE AwardID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $awardName, $categoryID, $description, $awardID);

    if ($stmt->execute()) {
        header("Location: ?page=awards&success=update");
        exit();
    } else {
        $error = "Error updating award: " . $conn->error;
    }
}

// Handle delete award
if (isset($_GET['delete'])) {
    $awardID = $_GET['delete'];

    // Check if award is being used in any recognitions
    $check_sql = "SELECT COUNT(*) as count FROM employeerecognition WHERE AwardID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $awardID);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();

    if ($check_row['count'] > 0) {
        $error = "Cannot delete award as it is being used in recognitions";
    } else {
        $sql = "DELETE FROM awards WHERE AwardID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $awardID);

        if ($stmt->execute()) {
            header("Location: ?page=awards&success=delete");
            exit();
        } else {
            $error = "Error deleting award: " . $conn->error;
        }
    }
}

// Get award details for edit
$edit_award = null;
if (isset($_GET['edit'])) {
    $awardID = $_GET['edit'];
    $sql = "SELECT a.*, c.CategoryName 
            FROM awards a 
            JOIN recognitioncategories c ON a.CategoryID = c.CategoryID 
            WHERE a.AwardID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $awardID);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_award = $result->fetch_assoc();
}

// Get award details for view
$view_award = null;
if (isset($_GET['view'])) {
    $awardID = $_GET['view'];
    $sql = "SELECT a.*, c.CategoryName 
            FROM awards a 
            JOIN recognitioncategories c ON a.CategoryID = c.CategoryID 
            WHERE a.AwardID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $awardID);
    $stmt->execute();
    $result = $stmt->get_result();
    $view_award = $result->fetch_assoc();
}

// Get all awards with categories
$sql = "SELECT a.*, c.CategoryName 
        FROM awards a 
        JOIN recognitioncategories c ON a.CategoryID = c.CategoryID 
        ORDER BY a.AwardID ASC";
$result = mysqli_query($conn, $sql);

// Get categories for dropdown
$categories_sql = "SELECT * FROM recognitioncategories ORDER BY CategoryName";
$categories_result = mysqli_query($conn, $categories_sql);
?>

<div class="container-fluid">
    <div class="page-header">
        <h1>Awards</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAwardModal">
            <i class="bi bi-plus-circle me-2"></i> Add Award
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($error)): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: <?php echo json_encode($error); ?>,
                });
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <?php
                $message = '';
                switch ($_GET['success']) {
                    case 'add':
                        $message = 'Award added successfully!';
                        break;
                    case 'update':
                        $message = 'Award updated successfully!';
                        break;
                    case 'delete':
                        $message = 'Award deleted successfully!';
                        break;
                }
                ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: <?php echo json_encode($message); ?>,
                    timer: 2000,
                    showConfirmButton: false
                });
            <?php endif; ?>
        });
    </script>

    <div class="table-container table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Award Name</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['AwardID']; ?></td>
                            <td><?php echo htmlspecialchars($row['AwardName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['CategoryName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="actions">
                                    <button class="btn" onclick="viewAward(<?php echo $row['AwardID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="View Awards">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn" onclick="editAward(<?php echo $row['AwardID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Awards">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn" onclick="confirmDeleteAward(<?php echo $row['AwardID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Award">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No awards found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Award Modal -->
<div class="modal fade" id="addAwardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Award</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="award_name" class="form-label">Award Name</label>
                        <input type="text" class="form-control" id="award_name" name="award_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <?php
                            mysqli_data_seek($categories_result, 0);
                            while ($cat = mysqli_fetch_assoc($categories_result)) {
                                echo "<option value='" . $cat['CategoryID'] . "'>" . $cat['CategoryName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_award" class="btn btn-primary ms-2">Add Award</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Award Modal -->
<div class="modal fade" id="editAwardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Award</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if ($edit_award): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="award_id" value="<?php echo $edit_award['AwardID']; ?>">
                        <div class="mb-3">
                            <label for="edit_award_name" class="form-label">Award Name</label>
                            <input type="text" class="form-control" id="edit_award_name" name="award_name"
                                value="<?php echo htmlspecialchars($edit_award['AwardName'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_category_id" class="form-label">Category</label>
                            <select class="form-select" id="edit_category_id" name="category_id" required>
                                <?php
                                mysqli_data_seek($categories_result, 0);
                                while ($cat = mysqli_fetch_assoc($categories_result)) {
                                    $selected = ($cat['CategoryID'] == $edit_award['CategoryID']) ? 'selected' : '';
                                    echo "<option value='" . $cat['CategoryID'] . "' " . $selected . ">" . $cat['CategoryName'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"><?php
                                                                                                                echo htmlspecialchars($edit_award['Description'], ENT_QUOTES, 'UTF-8');
                                                                                                                ?></textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="update_award" class="btn btn-primary ms-2">Update Award</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- View Award Modal -->
<div class="modal fade" id="viewAwardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Award Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if ($view_award): ?>
                    <div class="recognition-details">
                        <div class="detail-item">
                            <h6>Award Information</h6>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($view_award['AwardName'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($view_award['CategoryName'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($view_award['Description'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">Award details not found.</div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Bootstrap modals
    let viewModal, editModal, addModal;
    document.addEventListener('DOMContentLoaded', function() {
        viewModal = new bootstrap.Modal(document.getElementById('viewAwardModal'));
        editModal = new bootstrap.Modal(document.getElementById('editAwardModal'));
        addModal = new bootstrap.Modal(document.getElementById('addAwardModal'));

        // Show modals based on URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('view')) {
            viewModal.show();
        }
        if (urlParams.has('edit')) {
            editModal.show();
        }

        // Handle modal close events
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                // Remove URL parameters when modal is closed
                const url = new URL(window.location);
                url.searchParams.delete('view');
                url.searchParams.delete('edit');
                window.history.replaceState({}, '', url);
            });
        });
    });

    function viewAward(id) {
        window.location.href = '?page=awards&view=' + id;
    }

    function editAward(id) {
        window.location.href = '?page=awards&edit=' + id;
    }


    function deleteAward(id) {
        // Deprecated: replaced by confirmDeleteCategory with SweetAlert2
        if (confirm('Are you sure you want to delete this award?')) {
            window.location.href = '?page=awards&delete=' + id;
        }
    }

    function confirmDeleteAward(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '?page=awards&delete=' + id;
            }
        });
    }

    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>