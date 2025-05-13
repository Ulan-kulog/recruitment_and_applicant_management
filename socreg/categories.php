<?php
require_once 'socreg/config.php';

// Handle add category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $categoryName = $_POST['category_name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO recognitioncategories (CategoryName, Description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $categoryName, $description);

    if ($stmt->execute()) {
        header("Location: ?page=categories&success=add");
        exit();
    } else {
        $error = "Error adding category: " . $conn->error;
    }
}

// Handle update category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
    $categoryID = $_POST['category_id'];
    $categoryName = $_POST['category_name'];
    $description = $_POST['description'];

    $sql = "UPDATE recognitioncategories SET CategoryName = ?, Description = ? WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $categoryName, $description, $categoryID);

    if ($stmt->execute()) {
        header("Location: ?page=categories&success=update");
        exit();
    } else {
        $error = "Error updating category: " . $conn->error;
    }
}

// Handle delete category
if (isset($_GET['delete'])) {
    $categoryID = $_GET['delete'];

    // Check if category is being used in any awards
    $check_sql = "SELECT COUNT(*) as count FROM awards WHERE CategoryID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $categoryID);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();

    if ($check_row['count'] > 0) {
        $error = "Cannot delete category as it is being used in awards";
    } else {
        $sql = "DELETE FROM recognitioncategories WHERE CategoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoryID);

        if ($stmt->execute()) {
            header("Location: ?page=categories&success=delete");
            exit();
        } else {
            $error = "Error deleting category: " . $conn->error;
        }
    }
}

// Get category details for edit
$edit_category = null;
if (isset($_GET['edit'])) {
    $categoryID = $_GET['edit'];
    $sql = "SELECT * FROM recognitioncategories WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryID);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_category = $result->fetch_assoc();
}

// Get category details for view
$view_category = null;
if (isset($_GET['view'])) {
    $categoryID = $_GET['view'];
    $sql = "SELECT * FROM recognitioncategories WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryID);
    $stmt->execute();
    $result = $stmt->get_result();
    $view_category = $result->fetch_assoc();
}

// Get all categories
$sql = "SELECT * FROM recognitioncategories ORDER BY CategoryID ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="container-fluid">
    <div class="page-header">
        <h1>Categories</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-circle me-2"></i> Add Category
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
                        $message = 'Category added successfully!';
                        break;
                    case 'update':
                        $message = 'Category updated successfully!';
                        break;
                    case 'delete':
                        $message = 'Category deleted successfully!';
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

    <div class="table-container table-responsive" style="max-width: 1000px; width: 70%; margin: auto;">
        <table class="table" style="width: 100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['CategoryID']; ?></td>
                            <td><?php echo htmlspecialchars($row['CategoryName'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="actions">
                                    <button class="btn" onclick="viewCategory(<?php echo $row['CategoryID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="View Category">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn" onclick="editCategory(<?php echo $row['CategoryID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Category">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn" onclick="confirmDeleteCategory(<?php echo $row['CategoryID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Category">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No categories found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_category" class="btn btn-primary ms-2">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if ($edit_category): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="category_id" value="<?php echo $edit_category['CategoryID']; ?>">
                        <div class="mb-3">
                            <label for="edit_category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="category_name"
                                value="<?php echo htmlspecialchars($edit_category['CategoryName'], ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"><?php
                                                                                                                echo htmlspecialchars($edit_category['Description'], ENT_QUOTES, 'UTF-8');
                                                                                                                ?></textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="update_category" class="btn btn-primary ms-2">Update Category</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- View Category Modal -->
<div class="modal fade" id="viewCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Category Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if ($view_category): ?>
                    <div class="category-details">
                        <div class="detail-item">
                            <h6>Category Information</h6>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($view_category['CategoryName'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($view_category['Description'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">Category details not found.</div>
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
        viewModal = new bootstrap.Modal(document.getElementById('viewCategoryModal'));
        editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
        addModal = new bootstrap.Modal(document.getElementById('addCategoryModal'));

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

    function viewCategory(id) {
        window.location.href = '?page=categories&view=' + id;
    }

    function editCategory(id) {
        window.location.href = '?page=categories&edit=' + id;
    }

    function deleteCategory(id) {
        // Deprecated: replaced by confirmDeleteCategory with SweetAlert2
        if (confirm('Are you sure you want to delete this category?')) {
            window.location.href = '?page=categories&delete=' + id;
        }
    }

    function confirmDeleteCategory(id) {
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
                window.location.href = '?page=categories&delete=' + id;
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