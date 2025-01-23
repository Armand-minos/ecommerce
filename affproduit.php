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

<div class="cart-popup" id="cart-popup" style="display:none;">
    <h3>Your Cart</h3>
    <ul id="cart-items"></ul>
    <span class="close-popup" id="close-popup">Close</span>
    <span class="panier" id="panier" onclick="window.location.href='panier.php'">voir panier</span>
</div>

<div class="product-container">
    <div class="product">
        <img src="soap.jpg" alt="Soap Product" />
        <div class="product-details">
            <h2 class="product-title">Savon aux algues 150g</h2>
            <p>Price (TTC): <strong class="product-price">5.99</strong> €</p>
            <input type="number" class="quantity" value="1" min="1" style="width: 60px;">
            <button class="add-to-cart">Ajouter</button>
        </div>
    </div>

    <div class="product-container">
    <div class="product">
        <img src="soap.jpg" alt="Soap Product" />
        <div class="product-details">
            <h2 class="product-title">Savon liquide 500ml</h2>
            <p>Price (TTC): <strong class="product-price">15.99</strong> €</p>
            <input type="number" class="quantity" value="1" min="1" style="width: 60px;">
            <button class="add-to-cart">Ajouter</button>
        </div>
    </div>

    <div class="product">
        <img src="shampoo.jpg" alt="Shampoo Product" />
        <div class="product-details">
            <h2 class="product-title">Shampoing 1L</h2>
            <p>Price (TTC): <strong class="product-price">7.99</strong> €</p>
            <input type="number" class="quantity" value="1" min="1" style="width: 60px;">
            <button class="add-to-cart">Ajouter</button>
        </div>
    </div>
</div>
<script src="./javascript/script.js"></script>
</body>
</html>