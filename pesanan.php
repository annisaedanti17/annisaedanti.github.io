<?php
session_start();

if (!isset($_SESSION['kode_pesanan'])) {
    session_regenerate_id(true);
    $_SESSION['kode_pesanan'] = 'ORD-' . date('YmdHis');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $burger    = htmlspecialchars($_POST['nama_burger']);
    $harga     = filter_var($_POST['harga'], FILTER_VALIDATE_INT);
    $kuantitas = filter_var($_POST['kuantitas'], FILTER_VALIDATE_INT);

    if ($harga !== false && $kuantitas !== false && $kuantitas > 0) {
        foreach ($_SESSION['pesanan'] as &$item) {
            if ($item['nama_burger'] === $burger) {
                $item['kuantitas'] += $kuantitas;
                $item['total_harga'] = $item['harga'] * $item['kuantitas'];
                header("Location: pesanan.php");
                exit;
            }
        }
        $_SESSION['pesanan'][] = [
            'nama_burger' => $burger,
            'harga'       => $harga,
            'kuantitas'   => $kuantitas,
            'total_harga' => $harga * $kuantitas
        ];
    }
    header("Location: pesanan.php");
    exit;
}


// ------------------- B. TANGANI EDIT -------------------
$editIndex = null;
$editItem  = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit') {
    if (isset($_GET['index'])) {
        $editIndex = $_GET['index'];
        if (isset($_SESSION['pesanan'][$editIndex])) {
            $editItem = $_SESSION['pesanan'][$editIndex];
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit_index'])) {
    $editIndex         = $_POST['edit_index'];
    $new_burger        = $_POST['nama_burger'];
    $new_harga         = $_POST['harga'];
    $new_kuantitas     = $_POST['kuantitas'];
    $new_total_harga   = $new_harga * $new_kuantitas;

    $_SESSION['pesanan'][$editIndex] = [
        'nama_burger' => $new_burger,
        'harga'       => $new_harga,
        'kuantitas'   => $new_kuantitas,
        'total_harga' => $new_total_harga
    ];

    header("Location: pesanan.php");
    exit;
}

// ------------------- C. TANGANI PENAMBAHAN PESANAN BARU -------------------
if (isset($_GET['nama_burger']) && isset($_GET['harga'])) {
    $nama_burger = $_GET['nama_burger'];
    $harga       = $_GET['harga'];
} else {
    $nama_burger = "";
    $harga       = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['edit_index'])) {
    if (isset($_POST['nama_burger']) && isset($_POST['harga']) && isset($_POST['kuantitas'])) {
        $burger    = $_POST['nama_burger'];
        $harga     = $_POST['harga'];
        $kuantitas = $_POST['kuantitas'];

        $_SESSION['pesanan'][] = [
            'nama_burger' => $burger,
            'harga'       => $harga,
            'kuantitas'   => $kuantitas,
            'total_harga' => $harga * $kuantitas
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Anda</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            text-align: left;
        }

        select, input, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            margin-top: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Pesan Burger</h1>
    <form action="pesanan.php" method="POST">
        <label for="nama_burger">Nama Burger:</label>
        <select name="nama_burger" id="nama_burger" required>
            <option value="">--Pilih Burger--</option>
            <option value="Orniz">Orniz</option>
            <option value="Blapaniz">Blapaniz</option>
            <option value="Valoniz">Valoniz</option>
            <option value="Baniz">Baniz</option>
            <option value="Dodaaniz">Dodaaniz</option>
            <option value="Veniz">Veniz</option>
            <option value="Chiniz">Chiniz</option>
            <option value="Alieniz">Alieniz</option>
        </select>

        <label for="harga">Harga:</label>
        <input type="number" name="harga" id="harga" readonly required>

        <label for="kuantitas">Kuantitas:</label>
        <input type="number" name="kuantitas" id="kuantitas" value="1" min="1" required>

        <button type="submit">Tambahkan ke Pesanan</button>
    </form>
</div>

<script>
    var burgerPrices = {
        "Orniz": 20000,
        "Blapaniz": 35000,
        "Valoniz": 50000,
        "Baniz": 25000,
        "Dodaaniz": 35000,
        "Veniz": 65000,
        "Chiniz": 39000,
        "Alieniz": 150000
    };

    document.getElementById('nama_burger').addEventListener('change', function() {
        var selectedBurger = this.value;
        var priceInput = document.getElementById('harga');
        priceInput.value = burgerPrices[selectedBurger] || 0;
    });
</script>



    <!-- FORM EDIT PESANAN (Update) -->
    <?php if ($editItem !== null): ?>
    <h2>Edit Pesanan</h2>
    <form action="pesanan.php" method="POST">
        <input type="hidden" name="edit_index" value="<?php echo $editIndex; ?>">
        
        <label for="nama_burger">Nama Burger:</label>
        <select name="nama_burger" id="nama_burger" required>
            <option value="">--Pilih Burger--</option>
            <option value="Orniz" <?php if($editItem['nama_burger']=="Orniz") echo "selected"; ?>>Orniz</option>
            <option value="Blapaniz" <?php if($editItem['nama_burger']=="Blapaniz") echo "selected"; ?>>Blapaniz</option>
            <option value="Valoniz" <?php if($editItem['nama_burger']=="Valoniz") echo "selected"; ?>>Valoniz</option>
            <option value="Baniz" <?php if($editItem['nama_burger']=="Baniz") echo "selected"; ?>>Baniz</option>
            <option value="Dodaaniz" <?php if($editItem['nama_burger']=="Dodaaniz") echo "selected"; ?>>Dodaaniz</option>
            <option value="Veniz" <?php if($editItem['nama_burger']=="Veniz") echo "selected"; ?>>Veniz</option>
            <option value="Chiniz" <?php if($editItem['nama_burger']=="Chiniz") echo "selected"; ?>>Chiniz</option>
            <option value="Alieniz" <?php if($editItem['nama_burger']=="Alieniz") echo "selected"; ?>>Alieniz</option>
        </select>
        <br><br>

        <label for="harga">Harga:</label><br>
        <!-- Harga diupdate otomatis melalui JS, dan tetap read-only -->
        <input type="number" name="harga" id="harga" value="<?php echo $editItem['harga']; ?>" readonly required>
        <br><br>

        <label for="kuantitas">Kuantitas:</label><br>
        <input type="number" name="kuantitas" id="kuantitas" value="<?php echo $editItem['kuantitas']; ?>" min="1" required>
        <br><br>

        <button type="submit">Update Pesanan</button>
    </form>
    
    <!-- Script untuk mengubah nilai harga sesuai burger yang dipilih -->
    <script>
        var burgerPrices = {
            "Orniz": 20000,
            "Blapaniz": 35000,
            "Valoniz": 50000,
            "Baniz": 25000,
            "Dodaaniz": 35000,
            "Veniz": 65000,
            "Chiniz": 39000,
            "Alieniz": 150000
        };

        document.getElementById('nama_burger').addEventListener('change', function() {
            var selectedBurger = this.value;
            var priceInput = document.getElementById('harga');
            if (burgerPrices[selectedBurger]) {
                priceInput.value = burgerPrices[selectedBurger];
            } else {
                priceInput.value = 0;
            }
        });
    </script>
<?php endif; ?>

import React, { useState } from "react";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";

export default function OrderPage() {
  const [orders, setOrders] = useState([]);

  const addOrder = () => {
    const newOrder = { id: orders.length + 1, item: "Burger" };
    setOrders([...orders, newOrder]);
  };

  return (
    <div className="flex space-x-4">
      {/* Card Pemesanan Burger */}
      <Card className="w-64 p-4">
        <CardContent>
          <h2 className="text-lg font-bold">Pesan Burger</h2>
          <Button onClick={addOrder} className="mt-2">Tambah Pesanan</Button>
        </CardContent>
      </Card>

      {/* Daftar Pesanan */}
      <Card className="w-64 p-4">
        <CardContent>
          <h2 className="text-lg font-bold">Daftar Pesanan</h2>
          <ul>
            {orders.map((order) => (
              <li key={order.id}>{order.item} #{order.id}</li>
            ))}
          </ul>
        </CardContent>
      </Card>
    </div>
  );
}

</body>
</html>
