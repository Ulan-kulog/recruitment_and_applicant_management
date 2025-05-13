<?php
require_once 'config.php';

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_recognition'])) {
        // Create operation
        $employeeID = $_POST['employee_id'];
        $awardID = $_POST['award_id'];
        $recognitionDate = $_POST['recognition_date'];
        $notes = $_POST['notes'];

        $sql = "INSERT INTO employeerecognition (EmployeeID, AwardID, RecognitionDate, Description) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);               
        
        if (!$stmt) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("iiss", $employeeID, $awardID, $recognitionDate, $notes);
            
            if ($stmt->execute()) {
                header("Location: ?page=recognitions&success=add");
                exit();
            } else {
                $error = "Error adding recognition: " . $stmt->error;
            }
        }
    } elseif (isset($_POST['update_recognition'])) {
        // Update operation
        $recognitionID = $_POST['recognition_id'];
        $employeeID = $_POST['employee_id'];
        $awardID = $_POST['award_id'];
        $recognitionDate = $_POST['recognition_date'];
        $notes = $_POST['notes'];

        $sql = "UPDATE employeerecognition SET EmployeeID = ?, AwardID = ?, RecognitionDate = ?, Description = ? WHERE RecognitionID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissi", $employeeID, $awardID, $recognitionDate, $notes, $recognitionID);
        
        if ($stmt->execute()) {
            header("Location: ?page=recognitions&success=update");
            exit();
        } else {
            $error = "Error updating recognition: " . $conn->error;
        }
    }
}

// Handle Delete operation
if (isset($_GET['delete'])) {
    $recognitionID = $_GET['delete'];
    $sql = "DELETE FROM employeerecognition WHERE RecognitionID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recognitionID);
    
    if ($stmt->execute()) {
        header("Location: ?page=recognitions&success=delete");
        exit();
    } else {
        $error = "Error deleting recognition: " . $conn->error;
    }
}

// Get recognition details for edit
$edit_recognition = null;
if (isset($_GET['edit'])) {
    $recognitionID = $_GET['edit'];
    $sql = "SELECT * FROM employeerecognition WHERE RecognitionID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recognitionID);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_recognition = $result->fetch_assoc();
}

// Get recognition details for view
$view_recognition = null;
if (isset($_GET['view'])) {
    $recognitionID = $_GET['view'];
    $sql = "SELECT er.*, e.`Employee name` as employee_name, e.Department, e.Position, 
                   a.`AwardName` as award_name, a.Description as award_description,
                   c.CategoryName
            FROM employeerecognition er 
            JOIN employees e ON er.EmployeeID = e.EmployeeID 
            JOIN awards a ON er.AwardID = a.AwardID
            JOIN recognitioncategories c ON a.CategoryID = c.CategoryID
            WHERE er.RecognitionID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recognitionID);
    $stmt->execute();
    $result = $stmt->get_result();
    $view_recognition = $result->fetch_assoc();
}

// Get all recognitions with employee and award details
$sql = "SELECT er.*, e.`Employee name` as employee_name, a.`AwardName` as award_name 
        FROM employeerecognition er 
        JOIN employees e ON er.EmployeeID = e.EmployeeID 
        JOIN awards a ON er.AwardID = a.AwardID 
        ORDER BY er.RecognitionID ASC";
$result = mysqli_query($conn, $sql);

// Get employees for dropdown
$employees_sql = "SELECT * FROM employees ORDER BY `Employee name`";
$employees_result = mysqli_query($conn, $employees_sql);

// Get awards for dropdown with descriptions
$awards_sql = "SELECT * FROM awards ORDER BY AwardName";
$awards_result = mysqli_query($conn, $awards_sql);

// Store awards data for JavaScript
$awards_data = array();
while ($award = mysqli_fetch_assoc($awards_result)) {
    $awards_data[] = $award;
}
// Reset the pointer for later use
mysqli_data_seek($awards_result, 0);
?>

<div class="container-fluid">
    <div class="page-header">
        <h1>Employee Recognitions</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecognitionModal">
            <i class="bi bi-plus-circle me-2"></i> Add Recognition
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
                        $message = 'Recognition added successfully!';
                        break;
                    case 'update':
                        $message = 'Recognition updated successfully!';
                        break;
                    case 'delete':
                        $message = 'Recognition deleted successfully!';
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
                    <th>Employee</th>
                    <th>Award</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['RecognitionID']; ?></td>
                            <td><?php echo htmlspecialchars($row['employee_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['award_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['RecognitionDate'])); ?></td>
                            <td>
                                <div class="actions">
                                    <button class="btn" onclick="viewRecognition(<?php echo $row['RecognitionID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="View Recognition">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn" onclick="editRecognition(<?php echo $row['RecognitionID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Recognition">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn" onclick="confirmDeleteRecognition(<?php echo $row['RecognitionID']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Recognition">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No recognitions found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Recognition Modal -->
<div class="modal fade" id="addRecognitionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Recognition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="addRecognitionForm">
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select class="form-select" id="employee_id" name="employee_id" required>
                            <option value="">Select Employee</option>
                            <?php 
                            mysqli_data_seek($employees_result, 0);
                            while ($employee = mysqli_fetch_assoc($employees_result)): 
                            ?>
                                    <option value="<?php echo $employee['EmployeeID']; ?>">
                                    <?php echo htmlspecialchars($employee['Employee name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="award_id" class="form-label">Award</label>
                        <select class="form-select" id="award_id" name="award_id" required>
                            <option value="">Select Award</option>
                            <?php 
                            mysqli_data_seek($awards_result, 0);
                            while ($award = mysqli_fetch_assoc($awards_result)): 
                            ?>
                                    <option value="<?php echo $award['AwardID']; ?>" 
                                    data-description="<?php echo htmlspecialchars($award['Description'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($award['AwardName'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="recognition_date" class="form-label">Recognition Date</label>
                        <input type="date" class="form-control" id="recognition_date" name="recognition_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Description</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_recognition" class="btn btn-primary ms-2">Add Recognition</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Recognition Modal -->
<div class="modal fade" id="editRecognitionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Recognition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="editRecognitionForm">
                    <?php if ($edit_recognition): ?>
                        <input type="hidden" name="recognition_id" value="<?php echo $edit_recognition['RecognitionID']; ?>">
                        <div class="mb-3">
                            <label for="edit_employee_id" class="form-label">Employee</label>
                            <select class="form-select" id="edit_employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                <?php 
                                mysqli_data_seek($employees_result, 0);
                                while ($employee = mysqli_fetch_assoc($employees_result)): 
                                ?>
                                    <option value="<?php echo $employee['EmployeeID']; ?>" 
                                        <?php echo ($edit_recognition['EmployeeID'] == $employee['EmployeeID']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($employee['Employee name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_award_id" class="form-label">Award</label>
                            <select class="form-select" id="edit_award_id" name="award_id" required>
                                <option value="">Select Award</option>
                                <?php 
                                mysqli_data_seek($awards_result, 0);
                                while ($award = mysqli_fetch_assoc($awards_result)): 
                                ?>
                                    <option value="<?php echo $award['AwardID']; ?>" 
                                        data-description="<?php echo htmlspecialchars($award['Description'], ENT_QUOTES, 'UTF-8'); ?>"
                                        <?php echo ($edit_recognition['AwardID'] == $award['AwardID']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($award['AwardName'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_recognition_date" class="form-label">Recognition Date</label>
                            <input type="date" class="form-control" id="edit_recognition_date" name="recognition_date" 
                                value="<?php echo $edit_recognition['RecognitionDate']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_notes" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_notes" name="notes" rows="3"><?php 
                                echo htmlspecialchars($edit_recognition['Description'], ENT_QUOTES, 'UTF-8'); 
                            ?></textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="update_recognition" class="btn btn-primary ms-2">Update Recognition</button>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Recognition Modal -->
<div class="modal fade" id="viewRecognitionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recognition Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if ($view_recognition): ?>
                    <div class="recognition-details">
                        <div class="detail-item">
                            <h6>Employee Information</h6>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($view_recognition['employee_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Department:</strong> <?php echo htmlspecialchars($view_recognition['Department'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Position:</strong> <?php echo htmlspecialchars($view_recognition['Position'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        
                        <div class="detail-item">
                            <h6>Recognition Details</h6>
                            <p><strong>Award:</strong> <?php echo htmlspecialchars($view_recognition['award_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($view_recognition['RecognitionDate'])); ?></p>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($view_recognition['CategoryName'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($view_recognition['award_description'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">Recognition details not found.</div>
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
        viewModal = new bootstrap.Modal(document.getElementById('viewRecognitionModal'));
        editModal = new bootstrap.Modal(document.getElementById('editRecognitionModal'));
        addModal = new bootstrap.Modal(document.getElementById('addRecognitionModal'));

        // Show modals based on URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('view')) {
            viewModal.show();
        }
        if (urlParams.has('edit')) {
            editModal.show();
        }

        // Set today's date as default for recognition date in add modal
        document.getElementById('recognition_date').valueAsDate = new Date();

        // Handle award selection change for add modal
        document.getElementById('award_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const description = selectedOption.getAttribute('data-description');
            const notesTextarea = document.getElementById('notes');
            
            if (description && !notesTextarea.value) {
                notesTextarea.value = description;
            }
        });

        // Handle award selection change for edit modal
        const editAwardSelect = document.getElementById('edit_award_id');
        if (editAwardSelect) {
            editAwardSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const description = selectedOption.getAttribute('data-description');
                const notesTextarea = document.getElementById('edit_notes');
                
                if (description && !notesTextarea.value) {
                    notesTextarea.value = description;
                }
            });
        }

        // Handle form submissions
        const addForm = document.getElementById('addRecognitionForm');
        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                if (!validateAddForm()) {
                    e.preventDefault();
                }
            });
        }

        const editForm = document.getElementById('editRecognitionForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                if (!validateEditForm()) {
                    e.preventDefault();
                }
            });
        }

        // Handle modal close events
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function () {
                // Remove URL parameters when modal is closed
                const url = new URL(window.location);
                url.searchParams.delete('view');
                url.searchParams.delete('edit');
                window.history.replaceState({}, '', url);
            });
        });
    });

    function viewRecognition(id) {
        window.location.href = '?page=recognitions&view=' + id;
    }

    function editRecognition(id) {
        window.location.href = '?page=recognitions&edit=' + id;
    }

    function deleteRecognition(id) {
        // Deprecated: replaced by confirmDeleteRecognition with SweetAlert2
        if (confirm('Are you sure you want to delete this recognition?')) {
            window.location.href = '?page=recognitions&delete=' + id;
        }
    }

    function confirmDeleteRecognition(id) {
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
                window.location.href = '?page=recognitions&delete=' + id;
            }
        });
    }

    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

    function validateAddForm() {
        const employeeId = document.getElementById('employee_id').value;
        const awardId = document.getElementById('award_id').value;
        const recognitionDate = document.getElementById('recognition_date').value;
        
        if (!employeeId || !awardId || !recognitionDate) {
            alert('Please fill in all required fields');
            return false;
        }

        const today = new Date();
        const selectedDate = new Date(recognitionDate);
        if (selectedDate > today) {
            alert('Recognition date cannot be in the future');
            return false;
        }

        return true;
    }

    function validateEditForm() {
        const employeeId = document.getElementById('edit_employee_id').value;
        const awardId = document.getElementById('edit_award_id').value;
        const recognitionDate = document.getElementById('edit_recognition_date').value;
        
        if (!employeeId || !awardId || !recognitionDate) {
            alert('Please fill in all required fields');
            return false;
        }

        const today = new Date();
        const selectedDate = new Date(recognitionDate);
        if (selectedDate > today) {
            alert('Recognition date cannot be in the future');
            return false;
        }

        return true;
    }
</script>
