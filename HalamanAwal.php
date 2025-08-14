<?php
// Langkah 1: Tambahkan skrip keamanan di baris paling atas
include 'php/auth_check.php';
// Semua peran boleh mengakses halaman ini untuk berbelanja
check_role(['admin', 'kasir', 'gudang', 'user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko online AEJ</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="CSS/style.css" />
    <script
      type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-AeBOfGXsirsr6p_x"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body>
    <nav class="navbar" x-data>
      <a href="HalamanAwal.php" class="navbar-logo">Toko <span> AEJ</span></a>
      <div class="navbar-nav">
        <a href="#home">Home</a>
        <a href="#about">Tentang kami</a>
        <a href="produk.php">Produk</a>
        <a href="#contact">Kontak</a>
      </div>
      <div class="navbar-extra">
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>

      <form class="search-form" id="search-form">
        <input type="search" id="search-box" placeholder="search here..." />
        <label for="search-box"><i data-feather="search"></i></label>
      </form>

      <div class="shopping-cart" style="display: none;">
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
    
    <section class="hero" id="home">
      <div class="mask-container">
        <main class="content">
          <h1>Selamat datang di<span> AEJ</span></h1>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi,
            modi?
          </p>
        </main>
      </div>
    </section>
    
    <section id="about" class="about">
        <h2><span>Tentang </span>Kami</h2>
        <div class="row">
            <div class="about-img"><img src="img/tentang-kami.jpg" alt="Tentang Kami" /></div>
            <div class="content"><h3>Kenapa harus AEJ?</h3><p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vero earum ab, nulla mollitia provident dolore?</p><p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod, aspernatur?</p></div>
        </div>
    </section>

    <section id="contact" class="contact">
        <h2><span>Kontak</span> Kami</h2>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Non, sequi!</p>
        <div class="row">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d990.0442944073477!2d110.45754376965014!3d-6.988400399563282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708d48e9b9ba5d%3A0xfd0af8ee0705c33a!2sAditya%20Electric%20Jaya!5e0!3m2!1sid!2sid!4v1752759324447!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
            <form id="contact-form">
                <div class="input-group"><i data-feather="user"></i><input type="text" id="contact-name" placeholder="nama" required /></div>
                <div class="input-group"><i data-feather="mail"></i><input type="email" id="contact-email" placeholder="email" required /></div>
                <div class="input-group"><i data-feather="phone"></i><input type="text" id="contact-phone" placeholder="no hp" required /></div>
                <button type="submit" class="btn">Kirim pesan</button>
            </form>
        </div>
    </section>
    
    <footer>
        <div class="socials">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
        </div>
        <div class="links">
            <a href="#home">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="produk.php">Produk</a>
            <a href="#contact">Kontak</a>
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
      document.addEventListener('DOMContentLoaded', function() {
          const navbarNav = document.querySelector('.navbar-nav');
          const navbarExtra = document.querySelector('.navbar-extra');
          const hamburgerMenu = document.getElementById('hamburger-menu');

          const username = "<?php echo htmlspecialchars($_SESSION['username']); ?>";
          
          if (username) {
              // --- 1. Buat Elemen Info & Logout HANYA SEKALI ---
              const userInfo = document.createElement('span');
              userInfo.textContent = `Halo, ${username}`;
              userInfo.id = 'user-info-dynamic'; // Beri ID agar mudah ditemukan

              const logoutLink = document.createElement('a');
              logoutLink.href = 'php/LogoutProcess.php';
              logoutLink.innerHTML = '<i data-feather="log-out"></i>';
              logoutLink.id = 'logout-link-dynamic'; // Beri ID agar mudah ditemukan

              // --- 2. Buat Fungsi untuk Memindahkan Elemen ---
              function moveElementsBasedOnScreenSize() {
                  const screenWidth = window.innerWidth;
                  
                  if (screenWidth <= 768) {
                      // Tampilan Mobile: Pindahkan ke dalam .navbar-nav (menu hamburger)
                      // Pastikan elemen belum ada di sana untuk menghindari duplikasi
                      if (!navbarNav.contains(logoutLink)) {
                          navbarNav.appendChild(logoutLink);
                      }
                      if (!navbarNav.contains(userInfo)) {
                           // userInfo bisa ditambahkan juga jika diinginkan di menu mobile
                           // navbarNav.appendChild(userInfo); 
                      }
                  } else {
                      // Tampilan Desktop: Pindahkan ke dalam .navbar-extra
                      // Pastikan elemen belum ada di sana
                      if (!navbarExtra.contains(logoutLink)) {
                          navbarExtra.insertBefore(logoutLink, hamburgerMenu);
                      }
                      if (!navbarExtra.contains(userInfo)) {
                          navbarExtra.insertBefore(userInfo, hamburgerMenu);
                      }
                  }
                  feather.replace(); // Perbarui ikon setiap kali ada perubahan
              }

              // --- 3. Jalankan Fungsi ---
              // Panggil saat halaman pertama kali dimuat
              moveElementsBasedOnScreenSize();

              // Panggil lagi setiap kali ukuran jendela browser berubah
              window.addEventListener('resize', moveElementsBasedOnScreenSize);
          }
      });
    </script>
  </body>
</html>