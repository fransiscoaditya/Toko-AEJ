document.addEventListener('alpine:init',() => {
Alpine.data('products',() => ({
items: [
      { id: 1, name: 'Arduino uno', img: 'arduino-uno.jpg', price: 150000 },
      { id: 2, name: 'Arduino nano', img: 'arduino-nano.jpg', price: 100000 },
      { id: 3, name: 'breadboard', img: 'breadboard.jpg', price: 80000 },
      { id: 4, name: 'LCD', img: 'lcd-16x24.jpg', price: 70000 },
      { id: 5, name: 'Relay', img: 'relay.jpg', price: 25000 },
      { id: 6, name: 'ultrasonic sensor', img: 'ultrasonic-sensor.jpg', price: 150000 }, // Nama file baru
    ],
}));

Alpine.store('cart',{
items: [],
total: 0,
quantity: 0,
add(newItem){
    // cek barang yang sama di cart
    const cartitem = this.items.find((item) => item.id === newItem.id);


    // jika cart kosong
    if(!cartitem) {
        this.items.push({...newItem, quantity: 1, total: newItem.price});
        this.quantity++;
        this.total += newItem.price;
    }else{
        // cek barang apakah sama dengan yang ada di cart
        this.items = this.items.map((item) => {
            // jika barang beda
            if (item.id !== newItem.id) {
                return item;
            }else{
                // jika barang ada tambah jumlah dan total
                item.quantity++;
                item.total = item.price * item.quantity;
                this.quantity++;
                this.total += item.price;
                return item;
            }
        });
    }
},
remove(id){
    // ambil item remove berdasarkan id
    const cartItem = this.items.find((item) => item.id ===id);

    // jika barang lebih dari 1
    if(cartItem.quantity > 1) {
        // cari 1 1
        this.items = this.items.map((item) =>{
            // jika bukan skip
            if (item.id !== id) {
                return item;
            }else{
                item.quantity--;
                item.total = item.price * item.quantity;
                this.quantity--;
                this.total -= item.price;
                return item;
            }
        })
    } else if(cartItem.quantity === 1) {
        // jika barang sisa 1
        this.items = this.items.filter((item) => item.id !== id);
        this.quantity--;
        this.total-= cartItem.price;
    }
}
});
});

//konversi ke rupiah
const rupiah = (number) =>{
    return new Intl.NumberFormat('id-ID', {
        style:'currency',
        currency: `IDR`,
        minimumFractionDigits: 0
    }).format(number);
};