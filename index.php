<?php
declare(strict_types=1);

$prixTotal = filter_input(INPUT_GET, 'PrixTotal', FILTER_VALIDATE_FLOAT);
$prixLitre = filter_input(INPUT_GET, 'PrixLitre', FILTER_VALIDATE_FLOAT);
$kmMin = filter_input(INPUT_GET, 'KMmin', FILTER_VALIDATE_FLOAT);
$kmMax = filter_input(INPUT_GET, 'KMmax', FILTER_VALIDATE_FLOAT);

function kmTotal(float $kmMax, float $kmMin): float {
    return $kmMin == 0.0 ? $kmMax : $kmMax - $kmMin;
}

function litres(float $prixTotal, float $prixLitre): float {
    return $prixTotal / $prixLitre;
}

function consumptionPer100(float $litres, float $kmTotal): float {
    return $litres * 100 / $kmTotal;
}

function pricePerKm(float $kmTotal, float $prixTotal): float {
    return $prixTotal / $kmTotal;
}

function kmPerLitre(float $kmTotal, float $litres): float {
    return $kmTotal / $litres;
}

function litrePerKm(float $litres, float $kmTotal): float {
    return $litres / $kmTotal;
}

$errors = [];
$results = [];

if ($_GET) {
    if ($prixTotal === null || $prixLitre === null || $kmMin === null || $kmMax === null) {
        $errors[] = 'All fields must be filled with numeric values.';
    } else {
        $kmTotal = kmTotal($kmMax, $kmMin);
        $litres = litres($prixTotal, $prixLitre);
        $consumption = consumptionPer100($litres, $kmTotal);
        $priceKm = pricePerKm($kmTotal, $prixTotal);
        $kmPerLitre = kmPerLitre($kmTotal, $litres);
        $litrePerKm = litrePerKm($litres, $kmTotal);

        $results = [
            'kmTotal' => $kmTotal,
            'priceKm' => $priceKm,
            'consumption' => $consumption,
            'litres' => $litres,
            'kmPerLitre' => $kmPerLitre,
            'litrePerKm' => $litrePerKm,
        ];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fuel Calculator</title>
</head>
<body>
<h2>Fuel Calculator</h2>
<form action="" method="get">
    <p>Total price: <input type="text" name="PrixTotal" value="<?= htmlspecialchars($_GET['PrixTotal'] ?? '') ?>"></p>
    <p>Price per liter: <input type="text" name="PrixLitre" value="<?= htmlspecialchars($_GET['PrixLitre'] ?? '') ?>"></p>
    <p>Kilometers at the base (let 0 if you know already): <input type="text" name="KMmin" value="<?= htmlspecialchars($_GET['KMmin'] ?? '0') ?>"></p>
    <p>Total kilometers: <input type="text" name="KMmax" value="<?= htmlspecialchars($_GET['KMmax'] ?? '') ?>"></p>
    <p><input type="submit"></p>
</form>

<?php if ($errors): ?>
    <?php foreach ($errors as $error): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>
<?php elseif ($results): ?>
    <h3>Results</h3>
    <p>By paying <?= htmlspecialchars((string)$prixTotal) ?> for <?= htmlspecialchars((string)$prixLitre) ?> per liter you went across <?= htmlspecialchars((string)$results['kmTotal']) ?> KM.</p>
    <p>Price per kilometer: <?= htmlspecialchars((string)$results['priceKm']) ?></p>
    <p>Average consumption per 100 KM: <?= htmlspecialchars((string)$results['consumption']) ?> L</p>
    <p>Number of liters consumed: <?= htmlspecialchars((string)$results['litres']) ?> L</p>
    <p>Kilometers traveled per liter: <?= htmlspecialchars((string)$results['kmPerLitre']) ?> KM</p>
    <p>Consumed liters per kilometer: <?= htmlspecialchars((string)$results['litrePerKm']) ?> L</p>
<?php endif; ?>
</body>
</html>
