<?php

class Panier {
    private $items = [];
    private $clientName;
    private $orderReference;

    public function __construct($clientName, $orderReference) {
        $this->clientName = $clientName;
        $this->orderReference = $orderReference;
    }

    public function addItem($productName, $description, $priceHT, $taxRate, $quantity = 1) {
        $priceTTC = $priceHT * (1 + $taxRate);
        $totalPrice = $priceTTC * $quantity;

        if (isset($this->items[$productName])) {
            $this->items[$productName]['quantity'] += $quantity;
            $this->items[$productName]['totalPrice'] += $totalPrice;
        } else {
            $this->items[$productName] = [
                'description' => $description,
                'priceHT' => $priceHT,
                'priceTTC' => $priceTTC,
                'quantity' => $quantity,
                'totalPrice' => $totalPrice
            ];
        }
    }

    public function removeItem($productName) {
        if (isset($this->items[$productName])) {
            unset($this->items[$productName]);
        }
    }

    public function getTotals($shippingFees = 0) {
        $totalHT = 0;
        $totalTTC = 0;

        foreach ($this->items as $item) {
            $totalHT += $item['priceHT'] * $item['quantity'];
            $totalTTC += $item['totalPrice'];
        }

        $totalTTC += $shippingFees; 

        return [
            'totalHT' => $totalHT,
            'totalTVA' => $totalTTC - $totalHT,
            'shippingFees' => $shippingFees,
            'totalTTC' => $totalTTC
        ];
    }

    
    public function getItems() {
        return $this->items;
    }

    
    public function clear() {
        $this->items = [];
    }

    
    public function getClientInfo() {
        return [
            'clientName' => $this->clientName,
            'orderReference' => $this->orderReference
        ];
    }
}

echo "Client Name: " . $panier->getClientInfo()['clientName'] . "\n";
echo "Order Reference: " . $panier->getClientInfo()['orderReference'] . "\n";
echo "Total HT: €" . number_format($totals['totalHT'], 2) . "\n"; // Total HT
echo "Total TVA: €" . number_format($totals['totalTVA'], 2) . "\n"; // Total TVA
echo "Shipping Fees: €" . number_format($totals['shippingFees'], 2) . "\n"; // Shipping fees
echo "Total TTC: €" . number_format($totals['totalTTC'], 2) . "\n"; // Total TTC

print_r($panier->getItems());

$panier->clear();
?>