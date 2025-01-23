<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Product Page</title>
</head>
<body>

<div class="cart-icon" id="cart-icon">
    <span>🛒</span> <span id="cart-quantity">0</span>
</div>

<div class="cart-popup" id="cart-popup">
    <h3>Your Cart</h3>
    <ul id="cart-items"></ul>
    <span class="close-popup" id="close-popup">Close</span>
    <span class="panier" id="panier" onclick="window.location.href='panier.php'">voir panier</span>
</div>

<div class="product-container">
    <img src="soap.jpg" alt="Soap Product" />
    <div class="product-details">
        <h2>Luxury Soap</h2>
        <p>Price (TTC): <strong id="product-price">5.99</strong> €</p>
        <input type="number" id="quantity" value="1" min="1" style="width: 60px;">
        <button id="add-to-cart">Add to Cart</button>
    </div>
</div>

<script src="./javascript/script.js"></script>

</body>
</html>
