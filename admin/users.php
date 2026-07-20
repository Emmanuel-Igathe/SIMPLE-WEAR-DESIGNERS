<?php
require_once '../admin/auth.php';
require_once 'header.php';

// Pagination settings
$itemsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $itemsPerPage;

$conn = get_db_connection();

// Get total user count for pagination
$totalResult = $conn->query('SELECT COUNT(*) AS cnt FROM registration');
$totalRows = $totalResult->fetch_assoc()['cnt'];
$totalPages = ceil($totalRows / $itemsPerPage);

// Fetch users for current page
$stmt = $conn->prepare('SELECT id, firstName, lastName, email, is_admin FROM registration ORDER BY id DESC LIMIT ?, ?');
$stmt->bind_param('ii', $offset, $itemsPerPage);
$stmt->execute();
$res = $stmt->get_result();
?>
<div class="admin-main">
    <h2>User Management</h2>
    <table class="admin-table" style="width:100%; border-collapse:collapse; margin-top:20px;">
        <thead>
            <tr style="background:#2a2a48;">
                <th>ID</th><th>Name</th><th>Email</th><th>Admin?</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $res->fetch_assoc()): ?>
            <tr style="border-bottom:1px solid #444;">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo $row['is_admin'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <form method="post" action="user_toggle_admin.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                        <input type="hidden" name="current" value="<?php echo $row['is_admin']; ?>" />
                        <button type="submit" class="btn" style="background:#ff6b6b;">
                            <?php echo $row['is_admin'] ? 'Demote' : 'Promote'; ?>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <!-- Pagination -->
    <div style="margin-top:20px; text-align:center;">
        <?php if($page > 1): ?>
            <a href="?page=<?php echo $page-1; ?>" class="btn" style="margin-right:8px;">&laquo; Prev</a>
        <?php endif; ?>
        <?php if($page < $totalPages): ?>
            <a href="?page=<?php echo $page+1; ?>" class="btn">Next &raquo;</a>
        <?php endif; ?>
    </div>
</div>
<?php require_once 'footer.php'; ?>
