<?php
// 1. Tambahkan skrip keamanan di baris paling atas
include 'php/auth_check.php';
// Semua peran boleh mengakses halaman produk
check_role(['admin', 'kasir', 'gudang', 'user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk - Toko AEJ</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="CSS/style.css" />

    <script src="https://unpkg.com/feather-icons"></script>

    <script
      type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key=
    ></script>

    <script
      defer
      src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>
</head>
<body>
    <nav class="navbar" x-data>
        <a href="HalamanAwal.php" class="navbar-logo">Toko <span>AEJ</span></a>

        <div class="navbar-nav">
            <a href="HalamanAwal.php#home">Home</a>
            <a href="HalamanAwal.php#about">Tentang kami</a>
            <a href="produk.php">Produk</a>
            <a href="HalamanAwal.php#contact">Kontak</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="search-button"><i data-feather="search"></i></a>
            <a href="#" id="shopping-cart-button">
                <i data-feather="shopping-cart"></i>
                <span
                class="quantity-badge"
                x-show="$store.cart.quantity"
                x-text="$store.cart.quantity"
                ></span>
            </a>
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>

        <div class="search-form">
            <input type="search" id="search-box" placeholder="search here..." />
            <label for="search-box"><i data-feather="search"></i></label>
        </div>

        <div class="shopping-cart">
            <template x-for="(item, index) in $store.cart.items" x-keys="index">
                <div class="cart-item">
                    <img :src="`img/products/${item.img}`" :alt="item.name" />
                    <div class="item-detail">
                        <h3 x-text="item.name"></h3>
                        <div class="item-price">
                        <span x-text="rupiah(item.price)"></span> ×
                        <button id="remove" @click="$store.cart.remove(item.id)">
                            −
                        </button>
                        <span x-text="item.quantity"></span>
                        <button id="add" @click="$store.cart.add(item)">&plus;</button>
                        &equals;
                        <span x-text="rupiah(item.total)"></span>
                        </div>
                    </div>
                </div>
            </template>
            <h4 x-show="!$store.cart.items.length" style="margin-top: 1rem">
                Cart is Empty
            </h4>
            <h4 x-show="$store.cart.items.length">
                Total :<span x-text="rupiah($store.cart.total)"></span>
            </h4>

            <div class="form-container" x-show="$store.cart.items.length">
                <form action="" id="checkoutForm">
                    <input
                        type="hidden"
                        name="items"
                        x-model="JSON.stringify($store.cart.items)"
                    />
                    <input type="hidden" name="total" x-model="$store.cart.total" />

                    <h5>Customer Detail</h5>

                    <label for="name">
                        <span>Name</span>
                        <input type="text" name="name" id="name" required />
                    </label>

                    <label for="email">
                        <span>Email</span>
                        <input type="email" name="email" id="email" required />
                    </label>

                    <label for="phone">
                        <span>Phone</span>
                        <input
                        type="number"
                        name="phone"
                        id="phone"
                        autocomplete="off"
                        required
                        />
                    </label>

                    <button
                        class="checkout-button disabled"
                        type="submit"
                        id="checkout-button"
                    >
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <section
        class="products"
        id="products"
        x-data="produkData()"
        x-init="fetchProduk()"
    >
        <h2 style="margin-top: 8rem">Produk Kami <span>AEJ</span></h2>
        <p>
        Temukan berbagai produk pilihan terbaik dari Toko AEJ untuk kebutuhan
        Anda.
        </p>
        <div class="row">
            <template x-for="(item, index) in items" :key="index">
                <div class="product-card">
                    <div class="product-icons">
                        <a href="#" @click.prevent="$store.cart.add(item)">
                        <svg
                            width="24"
                            height="24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <use href="img/feather-sprite.svg#shopping-cart" />
                        </svg>
                        </a>
                    </div>
                    <div class="product-image">
                        <img :src="`img/products/${item.img}`" :alt="item.name" />
                    </div>
                    <div class="product-content">
                        <h3 x-text="item.name"></h3>
                        <div class="product-price">
                        <span x-text="rupiah(item.price)"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </section>

    <footer>
        <div class="socials">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
        </div>
        <div class="links">
            <a href="HalamanAwal.php#home">home</a>
            <a href="HalamanAwal.php#about">Tentang kami</a>
            <a href="HalamanAwal.php#contact">kontak</a>
        </div>
        <div class="credit">
            <p>Created by <a href="">Fransisco Aditya</a>. | © 2025.</p>
        </div>
    </footer>

    <script>
      feather.replace();
    </script>

    <script src="js/script.js"></script>
    <script src="src/app.js"></script>

    <script>
        function produkData() {
            return {
                items: [],
                async fetchProduk() {
                    try {
                        const res = await fetch("php/getOrder.php");
                        let allData = await res.json();

                        const urlParams = new URLSearchParams(window.location.search);
                        const searchTerm = urlParams.get('search');

                        if (searchTerm && searchTerm.trim() !== '') {
                            allData = allData.filter((item) =>
                                item.name.toLowerCase().includes(searchTerm.toLowerCase())
                            );
                        }

                        this.items = allData.map((item) => ({
                            ...item,
                            quantity: 1,
                            total: item.price,
                        }));
                    } catch (err) {
                        console.error("Gagal ambil produk:", err);
                    }
                },
            };
        }
    </script>

    <!-- Skrip navbar dinamis yang sudah dimodifikasi -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          const navbarNav = document.querySelector('.navbar-nav');
          const navbarExtra = document.querySelector('.navbar-extra');
          const hamburgerMenu = document.getElementById('hamburger-menu');

          const username = "<?php echo htmlspecialchars($_SESSION['username']); ?>";
          
          if (username) {
              // Elemen userInfo tidak lagi dibuat

              const logoutLink = document.createElement('a');
              logoutLink.href = 'php/LogoutProcess.php';
              logoutLink.innerHTML = '<i data-feather="log-out"></i>';
              logoutLink.id = 'logout-link-dynamic';

              function moveElementsBasedOnScreenSize() {
                  const screenWidth = window.innerWidth;
                  
                  if (screenWidth <= 768) {
                      // Tampilan Mobile: Pindahkan logout link ke menu hamburger
                      if (!navbarNav.contains(logoutLink)) {
                          navbarNav.appendChild(logoutLink);
                      }
                  } else {
                      // Tampilan Desktop: Pindahkan logout link ke navbar-extra
                      if (!navbarExtra.contains(logoutLink)) {
                          navbarExtra.insertBefore(logoutLink, hamburgerMenu);
                      }
                  }
                  feather.replace();
              }

              moveElementsBasedOnScreenSize();
              window.addEventListener('resize', moveElementsBasedOnScreenSize);
          }
      });
    </script>
</body>
</html>