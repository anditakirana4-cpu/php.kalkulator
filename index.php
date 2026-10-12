
<?php
$menu = [
    "Mie Ayam Spesial" => 18000,
    "Mie Ayam Biasa"  => 12000,
    "Bakso Pentol"    => 10000,
    "Bakso Biasa"     => 12000
];

$jumlah = [];
$total = 0;

foreach ($menu as $nama => $harga) {
    $key = md5($nama);
    $jumlah[$nama] = isset($_POST[$key])
        ? max(0, min(99, (int)$_POST[$key]))
        : 0;

    $total += $jumlah[$nama] * $harga;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kalkulator Mie Ayam & Bakso</title>

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    color: #17365d;
    background: linear-gradient(135deg, #eaf5ff, #c9e4ff);
    min-height: 100vh;
}

header {
    background: linear-gradient(120deg, #071d49, #1769aa);
    color: white;
    text-align: center;
    padding: 40px 20px 65px;
    border-bottom: 4px solid #e9bd69;
}

header h1 {
    margin: 0 0 12px;
    font-size: 32px;
}

header p {
    margin: 0;
    color: #d9ecff;
}

.container {
    max-width: 850px;
    margin: -30px auto 30px;
    padding: 0 16px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 12px 35px #153d6820;
    border: 1px solid #d7e9fa;
}

h2 {
    margin-top: 0;
    color: #10366c;
}

.menu {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.item {
    padding: 18px;
    border: 1px solid #d4e6f8;
    background: #f6fbff;
    border-radius: 15px;
}

.item h3 {
    margin: 0 0 10px;
    font-size: 17px;
}

.harga {
    color: #1769aa;
    font-weight: bold;
    margin-bottom: 15px;
}

input[type=number] {
    width: 100%;
    padding: 11px;
    border: 1px solid #b9d5f0;
    border-radius: 9px;
    font-size: 16px;
}

button, .reset {
    display: inline-block;
    padding: 13px 18px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
}

button {
    background: linear-gradient(120deg, #1769aa, #071d49);
    color: white;
}

.reset {
    background: #e7f2ff;
    color: #10366c;
}

.tombol {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 22px;
}

.hasil {
    margin-top: 22px;
    background: linear-gradient(120deg, #071d49, #1769aa);
    color: white;
    padding: 25px;
    border-radius: 18px;
}

.hasil h2 {
    color: white;
}

.rincian {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #ffffff35;
}

.total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-top: 20px;
    font-size: 18px;
}

.total strong {
    color: #ffe19c;
    font-size: 25px;
}

footer {
    text-align: center;
    padding: 20px;
    color: #526c8a;
    font-size: 13px;
}

@media (max-width: 560px) {
    .menu {
        grid-template-columns: 1fr;
    }

    header h1 {
        font-size: 26px;
    }

    .card {
        padding: 18px;
    }
}
</style>
</head>

<body>

<header>
    <h1>✦ Mie Ayam & Bakso ✦</h1>
    <p>Kalkulator Pesanan • Cepat, Mudah, dan Praktis</p>
</header>

<div class="container">
    <section class="card">
        <h2>🍜 Pilih Menu Favorit</h2>
        <p>Masukkan jumlah porsi yang ingin dipesan.</p>

        <form method="POST">
            <div class="menu">

                <?php foreach ($menu as $nama => $harga): ?>
                <div class="item">
                    <h3><?= htmlspecialchars($nama) ?></h3>

                    <div class="harga">
                        Rp<?= number_format($harga, 0, ',', '.') ?>
                    </div>

                    <label for="<?= md5($nama) ?>">
                        Jumlah porsi
                    </label>

                    <input
                        type="number"
                        id="<?= md5($nama) ?>"
                        name="<?= md5($nama) ?>"
                        min="0"
                        max="99"
                        value="<?= $jumlah[$nama] ?>"
                    >
                </div>
                <?php endforeach; ?>

            </div>

            <div class="tombol">
                <button type="submit">✦ Hitung Total</button>
                <a href="" class="reset">Reset Pesanan</a>
            </div>
        </form>
    </section>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
    <section class="hasil">
        <h2>Ringkasan Pesanan</h2>

        <?php
        $adaPesanan = false;

        foreach ($menu as $nama => $harga):
            if ($jumlah[$nama] > 0):
                $adaPesanan = true;
        ?>
            <div class="rincian">
                <span>
                    <?= htmlspecialchars($nama) ?>
                    × <?= $jumlah[$nama] ?>
                </span>

                <strong>
                    Rp<?= number_format(
                        $harga * $jumlah[$nama],
                        0, ',', '.'
                    ) ?>
                </strong>
            </div>
        <?php
            endif;
        endforeach;
        ?>

        <?php if (!$adaPesanan): ?>
            <p>Belum ada menu yang dipilih.</p>
        <?php endif; ?>

        <div class="total">
            <span>Total Bayar</span>
            <strong>
                Rp<?= number_format($total, 0, ',', '.') ?>
            </strong>
        </div>
    </section>
    <?php endif; ?>
</div>

<footer>
    ✦ Mie Ayam & Bakso • Nikmat dalam Setiap Sajian ✦
</footer>

</body>
</html>
