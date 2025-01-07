<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../includes/auth.php';
include '../../includes/sales.php';
include '../../includes/medicine.php';

if (!isLoggedIn()) {
    header("Location: ../../auth/login.php");
    exit();
}

$user = $_SESSION['user'];

// fetch and validate medicine
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'fetch_suggestions') {
        $medicineName = $_GET['name'];
        $medicines = fetchMedicineSuggestions($medicineName);
        echo json_encode($medicines);
        exit;
    } elseif ($_GET['action'] == 'validate_medicine') {
        $medicineName = $_GET['name'];
        $exists = validateMedicine($medicineName);
        echo json_encode(['exists' => $exists]);
        exit;
    }
}

// post request to create sale
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $medicine = $_POST['medicine'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $sold_by = $_POST['sold_by'];

    if (createSale($medicine, $quantity, $total_price, $sold_by)) {
        header("Location: ../../views/sales/main_sales.php?success=Sale created successfully");
        exit();
    } else {
        header("Location: ../../views/sales/create_sales.php?error=Failed to create sale");
        exit();
    }
}

// get medicine price
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'fetch_medicine') {
        $medicineName = $_GET['name'];
        $medicine = getMedicineByName($medicineName);
        echo json_encode($medicine);
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Sale</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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
                        <p>Manage Medicine</p>
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

        <!-- Main Content -->
        <div class="flex-1">
            <h1 class="text-3xl text-white p-4 mb-6 font-bold bg-gray-600 w-full sticky top-0 z-50">Create Sale</h1>
            <?php if (isset($_GET['error'])): ?>
                <p class="text-red-500"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif; ?>
            <div class="flex flex-col items-center">
                <form method="POST" class="bg-white p-6 rounded shadow-md w-11/12">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-4">
                        <label for="medicine" class="block text-gray-700 font-bold">Medicine Name</label>
                        <input type="text" id="medicine" name="medicine" placeholder="Enter medicine name" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" oninput="fetchSuggestions()" onblur="closeSuggestions()">
                        <div id="suggestions" class="border rounded mt-2"></div>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 font-bold">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="1" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" oninput="countPrice()">
                    </div>
                    <div class="mb-4">
                        <label for="total_price_display" class="block text-gray-700 font-bold">Total Price</label>
                        <input disabled type="number" id="total_price_display" name="total_price_display" placeholder="Rp. 0" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <input type="hidden" id="total_price" name="total_price">
                    </div>
                    <div class="mb-4">
                        <label for="sold_by_display" class="block text-gray-700 font-bold">Sold By</label>
                        <input disabled type="text" id="sold_by_display" name="sold_by_display" value="<?php echo $user['username'] ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <input type="hidden" id="sold_by" name="sold_by" value="<?php echo $user['username'] ?>">
                    </div>
                    <div class="flex justify-between">
                        <a href="main_sales.php" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    let suggestionClicked = false;

    function fetchSuggestions() {
        const medicineName = document.getElementById('medicine').value;
        if (medicineName.length >= 3) {
            fetch('create_sales.php?action=fetch_suggestions&name=' + medicineName)
                .then(response => response.json())
                .then(data => {
                    const suggestionsDiv = document.getElementById('suggestions');
                    suggestionsDiv.innerHTML = '';
                    data.forEach(medicine => {
                        const div = document.createElement('div');
                        div.textContent = medicine.name;
                        div.classList.add('suggestion-item', 'p-2', 'hover:bg-gray-200', 'cursor-pointer', 'text-sm', "rounded", "border-b", "text-gray-700");
                        div.onclick = () => {
                            document.getElementById('medicine').value = medicine.name;
                            suggestionsDiv.innerHTML = '';
                            suggestionClicked = true;
                            countPrice();
                        };
                        suggestionsDiv.appendChild(div);
                    });
                });
        }
    }

    function closeSuggestions() {
        setTimeout(() => {
            if (!suggestionClicked) {
                document.getElementById('suggestions').innerHTML = '';
                const medicineName = document.getElementById('medicine').value;
                if (medicineName) {
                    fetch('create_sales.php?action=validate_medicine&name=' + encodeURIComponent(medicineName))
                        .then(response => response.json())
                        .then(data => {
                            if (!data.exists) {
                                alert('Medicine name does not exist');
                            } else {
                                countPrice();
                            }
                        })
                        .catch(error => {
                            console.error('Error validating medicine name:', error);
                            alert('An error occurred while validating the medicine name.');
                        });
                }
            }
            suggestionClicked = false; 
        }, 200);
    }

    function countPrice() {
        const quantity = document.getElementById('quantity').value;
        const medicine = document.getElementById('medicine').value;

        if (!medicine || quantity <= 0) {
            alert('Please enter valid medicine name and quantity.');
            return;
        }

        fetch('create_sales.php?action=fetch_medicine&name=' + encodeURIComponent(medicine))
            .then(response => response.json())
            .then(data => {
                if (data && data.price) {
                    const price = data.price;
                    const totalPrice = price * quantity;
                    document.getElementById('total_price_display').value = totalPrice;
                    document.getElementById('total_price').value = totalPrice;
                } else {
                    alert('Failed to fetch price for the selected medicine.');
                }
            })
            .catch(error => {
                console.error('Error fetching medicine price:', error);
                alert('An error occurred while calculating the total price.');
            });
    }
</script>

</html>