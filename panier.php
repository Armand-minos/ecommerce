<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Panier</title>
</head>
<body>
    <?php include './navbar/header.php'; ?>

    <h1>Votre Panier</h1>
    <table id="cart-items">
        <thead>
            <tr>
                <th>Nom du Produit</th>
                <th>Description</th>
                <th>Prix Unitaire (HT)</th>
                <th>Quantité</th>
                <th>Prix Total (HT)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="cart-body"></tbody>
    </table>

    <div id="totals">
        <p>Total HT: <span id="total-ht">0.00</span> €</p>
        <p>TVA (20%): <span id="total-tva">0.00</span> €</p>
        <p>Total TTC: <span id="total-ttc">0.00</span> €</p>
    </div>

    <button id="checkout" ref="payment.php">Procéder au Paiement</button>
    <button id="clear-cart">Vider le Panier</button>

    <script src="./javascript/script.js"></script>
</body>
</html>