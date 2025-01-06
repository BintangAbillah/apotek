<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../includes/auth.php';
include '../../includes/sales.php';
if (!isLoggedIn()) {
    header("Location: ../../auth/login.php");
    exit();
}

$user = $_SESSION['user'];
$sales = getSales();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <!-- tailwindcss -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- datables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/54e497b2de.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white p-4 sticky top-0">
            <h2 class="text-2xl font-bold mb-4"><?php echo strtoupper($user['role']) ?>, <?php echo strtoupper($user['username']) ?></h2>
            <ul>
                <li>
                    <a href="../dashboard.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-gauge"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="../medicine/main_medicine.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-pills"></i>
                        <p>Manage Medicines</p>
                    </a>
                </li>
                <li>
                    <a href="main_sales.php" class="bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-money-bill"></i>
                        <p>Sales</p>
                    </a>
                </li>
                <li>
                    <a href="./users/main_users.php" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-user"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li>
                    <a href="../../includes/auth.php?action=logout" class="hover:bg-gray-700 py-2 pl-4 rounded-md block flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Dashboard -->
        <div class="flex-1">
            <h1 class="text-3xl text-white p-4 mb-6 font-bold bg-gray-600 w-full sticky top-0 z-50">Manage Sale</h1>
            <div class="flex flex-col items-center">
                <div class="flex items-start w-11/12">
                    <a href="create_sales.php" class="bg-blue-800 text-white px-4 py-2 mb-4 rounded hover:bg-blue-700 hover:underline">Add Sale</a>
                </div>
                <div class="on w-11/12">
                    <table id="saleTable" class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">ID</th>
                                <th class="border border-gray-300 px-4 py-2">Medicine</th>
                                <th class="border border-gray-300 px-4 py-2">Quantity</th>
                                <th class="border border-gray-300 px-4 py-2">Total Price</th>
                                <th class="border border-gray-300 px-4 py-2">Sold By</th>
                                <th class="border border-gray-300 px-4 py-2">Sale Date</th>
                                <th class="border border-gray-300 px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($sales)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">No sales available.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($sales as $sale): ?>
                                    <tr class="bg-gray-100 hover:bg-gray-200 active:bg-gray-300">
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($sale['id']); ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($sale['medicine']); ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($sale['quantity']); ?></td>
                                        <td class="border border-gray-300 px-4 py-2">Rp. <?= number_format(htmlspecialchars($sale['total_price']), 0, ',', '.'); ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= $sale['sold_by'] ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= $sale['sale_date'] ?></td>
                                        <td class="border border-gray-300 px-4 py-2 flex gap-2">
                                            <div class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-400"><a href="edit_sales.php?id=<?= $sale['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a></div>
                                            <div class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-400 cursor-pointer" onclick="softDeleteSale(<?php echo $sale['id']; ?>)"><i class="fa-solid fa-trash"></i></div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#saleTable').DataTable({
                "responsive": true,
                "scrollX": true,
                "autoWidth": true,
                "pageLength": 25,
                "lengthMenu": [5, 10, 25, 50, 100],
                "order": [
                    [0, 'desc']
                ],
                "language": {
                    "paginate": {
                        "first": "<<",
                        "last": ">>",
                        "next": ">",
                        "previous": "<"
                    },
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries to show",
                    "lengthMenu": "Show _MENU_ entries",
                    "search": "Find:",
                    "zeroRecords": "No matching records found"
                }
            });
        });

        function softDeleteSale(id) {
            if (confirm("Are you sure you want to delete this sale?")) {
                fetch(`../../includes/sale.php?action=soft_delete&id=${id}`, {
                        method: 'GET',
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            alert('Sale deleted successfully!');
                            window.location.reload();
                        } else {
                            alert('Failed to delete sale: ' + data);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>

</html>