document.addEventListener('alpine:init', () => {
    // Definisi data produk
    Alpine.data('products', () => ({
        items: [
            { id: 1, name: 'Arduino uno', img: 'arduino-uno.jpg', price: 150000 },
            { id: 2, name: 'Arduino nano', img: 'arduino-nano.jpg', price: 100000 },
            { id: 3, name: 'breadboard', img: 'breadboard.jpg', price: 80000 },
            { id: 4, name: 'LCD', img: 'lcd-16x24.jpg', price: 70000 },
            { id: 5, name: 'Relay', img: 'relay.jpg', price: 25000 },
            { id: 6, name: 'ultrasonic sensor', img: 'ultrasonic-sensor.jpg', price: 150000 },
        ],
    }));

    // Definisi store untuk keranjang belanja
    Alpine.store('cart', {
        items: [],
        total: 0,
        quantity: 0,
        add(newItem) {
            const cartItem = this.items.find((item) => item.id === newItem.id);
            if (!cartItem) {
                this.items.push({ ...newItem, quantity: 1, total: newItem.price });
                this.quantity++;
                this.total += newItem.price;
            } else {
                this.items = this.items.map((item) => {
                    if (item.id !== newItem.id) {
                        return item;
                    } else {
                        item.quantity++;
                        item.total = item.price * item.quantity;
                        this.quantity++;
                        this.total += item.price;
                        return item;
                    }
                });
            }
        },
        remove(id) {
            const cartItem = this.items.find((item) => item.id === id);
            if (cartItem.quantity > 1) {
                this.items = this.items.map((item) => {
                    if (item.id !== id) {
                        return item;
                    } else {
                        item.quantity--;
                        item.total = item.price * item.quantity;
                        this.quantity--;
                        this.total -= item.price;
                        return item;
                    }
                });
            } else if (cartItem.quantity === 1) {
                this.items = this.items.filter((item) => item.id !== id);
                this.quantity--;
                this.total -= cartItem.price;
            }
        }
    });
});

// ✅ KODE YANG DIPERBAIKI ADA DI SINI
// Fungsi global untuk format Rupiah
function rupiah(number) {
    if (!number) return 'Rp 0';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}
// Pastikan fungsi 'rupiah' tersedia secara global
window.rupiah = rupiah;

// LOGIKA UNTUK CHECKOUT FORM (setelah DOM siap)
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#checkoutForm');
    const checkoutButton = document.querySelector('#checkout-button');

    if (form) {
        // Kondisi awal tombol
        checkoutButton.disabled = true;
        checkoutButton.classList.add('disabled');

        // Validasi form
        form.addEventListener('input', function () {
            let allFilled = true;
            form.querySelectorAll('[required]').forEach(input => {
                if (input.value.trim().length === 0) {
                    allFilled = false;
                }
            });
            
            if (allFilled) {
                checkoutButton.disabled = false;
                checkoutButton.classList.remove('disabled');
            } else {
                checkoutButton.disabled = true;
                checkoutButton.classList.add('disabled');
            }
        });
        
        // Aksi tombol checkout
        checkoutButton.addEventListener('click', async function (e) {
            e.preventDefault();
            const formData = new FormData(form);
            const data = new URLSearchParams(formData);
            const objData = Object.fromEntries(data);

            try {
                const response = await fetch('php/placeOrder.php', {
                    method: 'POST',
                    body: data,
                });
                const token = await response.text();
                
                window.snap.pay(token, {
                    onSuccess: function(result){
                        const successOverlay = document.getElementById('payment-success-overlay');
                        successOverlay.classList.add('show');
                        console.log(result);
                        setTimeout(() => {
                            successOverlay.classList.remove('show');
                        }, 4000);
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran Anda!"); 
                        console.log(result);
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!"); 
                        console.log(result);
                    },
                    onClose: function(){
                        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                    }
                });

            } catch (err) {
                console.log(err.message);
            }
        });
    }
});