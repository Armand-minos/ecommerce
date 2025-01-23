// script.js

document.addEventListener('DOMContentLoaded', function() {
    const cartQuantity = document.getElementById('cart-quantity');
    const cartIcon = document.getElementById('cart-icon');
    const cartPopup = document.getElementById('cart-popup');
    const cartItems = document.getElementById('cart-items');
    const closePopup = document.getElementById('close-popup');

    // Load initial cart quantity from localStorage
    const updateCartDisplay = () => {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartQuantity.textContent = totalQuantity;
    };

    const renderCartPopup = () => {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartItems.innerHTML = '';
        if (cart.length === 0) {
            cartItems.innerHTML = '<li>Your cart is empty.</li>';
        } else {
            cart.forEach(item => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `${item.name} x ${item.quantity} - ${(item.price * item.quantity).toFixed(2)} €`;
                cartItems.appendChild(listItem);
            });
        }
    };

    // Add event listeners to all "Add to Cart" buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const productContainer = button.closest('.product');
            const price = parseFloat(productContainer.querySelector('.product-price').textContent);
            const quantity = parseInt(productContainer.querySelector('.quantity').value);
            const productName = productContainer.querySelector('.product-title').textContent;

            if (quantity > 0) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const productIndex = cart.findIndex(item => item.name === productName);

                if (productIndex > -1) {
                    cart[productIndex].quantity += quantity; // Ajoute à la quantité existante
                } else {
                    cart.push({ name: productName, price: price, quantity: quantity });
                } 

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                alert('Product added to cart!');
            } else {
                alert('Please enter a valid quantity.');
            }
        });
    });

    cartIcon.addEventListener('click', () => {
        renderCartPopup();
        cartPopup.style.display = 'block';
    });

    closePopup.addEventListener('click', () => {
        cartPopup.style.display = 'none';
    });

    updateCartDisplay(); // Met à jour l'affichage du panier au chargement de la page
});

// script.js

document.addEventListener('DOMContentLoaded', function() {
    const cartBody = document.getElementById('cart-body');
    const totalHT = document.getElementById('total-ht');
    const totalTVA = document.getElementById('total-tva');
    const totalTTC = document.getElementById('total-ttc');
    const clearCartButton = document.getElementById('clear-cart');

    // Fonction pour charger le panier
    const loadCart = () => {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartBody.innerHTML = ''; // Efface les éléments existants
        let totalHTValue = 0;

        if (cart.length === 0) {
            cartBody.innerHTML = '<tr><td colspan="6">Votre panier est vide.</td></tr>';
        } else {
            cart.forEach((item, index) => {
                const priceTotal = (item.price * item.quantity).toFixed(2);
                totalHTValue += item.price * item.quantity;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td>${item.description || 'N/A'}</td>
                    <td>${item.price.toFixed(2)} €</td>
                    <td>${item.quantity}</td>
                    <td>${priceTotal} €</td>
                    <td><button class="remove-item" data-index="${index}">Supprimer</button></td>
                `;
                cartBody.appendChild(row);
            });
        }

        // Calculer les totaux
        const vat = totalHTValue * 0.2; // 20% de TVA
        const totalTTCValue = totalHTValue + vat;

        totalHT.textContent = totalHTValue.toFixed(2);
        totalTVA.textContent = vat.toFixed(2);
        totalTTC.textContent = totalTTCValue.toFixed(2);
    };

    // Supprimer un article du panier
    cartBody.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-item')) {
            const index = event.target.getAttribute('data-index');
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1); // Supprime l'article du panier
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart(); // Recharge le panier après suppression
        }
    });

    // Vider le panier
    clearCartButton.addEventListener('click', () => {
        localStorage.removeItem('cart'); // Supprime le panier du localStorage
        loadCart(); // Recharge le panier
    });

    // Charger le panier au chargement de la page
    loadCart();
});