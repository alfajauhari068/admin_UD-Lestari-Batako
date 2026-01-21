<link rel="stylesheet" href="{{ asset('css/theme-industrial.css') }}">
<link rel="stylesheet" href="{{ asset('css/industrial-components.css') }}">

<style>
/* Legacy Auth Styles - To be refactored with theme */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.card-hover-blue {
    background: linear-gradient(135deg, #1e88e5, #42a5f5, #bbdefb);
    transition: transform 0.3s ease;
    border-radius: 16px;
}

.card-hover-blue:hover {
    transform: translateY(-5px) scale(1.02);
}



#auth {
    display: flex;
    min-height: 90vh;
    background: linear-gradient(to right, #4e73df, #224abe);
}

/* Left Section (Form Login) */
#auth-left {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 50%; /* Lebar lebih kecil */
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin: auto; /* Pusatkan form */
}

.auth-logo img {
    width: 80px; /* Ukuran logo lebih kecil */
    margin-bottom: 15px;
}



.auth-subtitle {
    font-size: 14px; /* Ukuran font lebih kecil */
    color: #6c757d;
    margin-bottom: 15px;
}

/* Right Section (Content) */
#auth-right {
    width: 70%; /* Lebar lebih besar untuk konten tambahan */
    background: url('assets/images/auth-bg.jpg') no-repeat center center;
    background-size: cover;
    border-radius: 0 12px 12px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    text-align: center;
    padding: 20px;
    position: sticky; /* Tetap pada posisinya saat di-scroll */
    top: 0; /* Posisi tetap di bagian atas */
    height: 100vh; /* Tinggi penuh untuk viewport */
}

#auth-right h1 {
    font-size: 28px; /* Ukuran font lebih kecil */
    font-weight: bold;
    margin-bottom: 10px;
}

#auth-right p {
    font-size: 14px; /* Ukuran font lebih kecil */
    line-height: 1.5;
}

/* Form Styles */
.form-control-sm {
    height: 35px; /* Tinggi input lebih kecil */
    font-size: 14px; /* Ukuran font lebih kecil */
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control-sm:focus {
    border-color: #224abe;
    box-shadow: 0 0 5px rgba(34, 74, 190, 0.5);
}

.form-control-icon {
    position: absolute;
    top: 50%;
    left: 10px; /* Jarak lebih kecil */
    transform: translateY(-50%);
    color: #6c757d;
}

.form-group {
    position: relative;
    margin-bottom: 15px; /* Jarak antar elemen lebih kecil */
}

.form-control {
    width: 100%; /* Pastikan input memiliki lebar penuh */
    padding: 5px;
    box-sizing: border-box; /* Pastikan padding tidak memengaruhi lebar elemen */
}

.btn-primary {
    background-color: #224abe;
    border: none;
    border-radius: 8px;
    padding: 10px 16px; /* Padding lebih kecil */
    font-size: 14px; /* Ukuran font lebih kecil */
    font-weight: bold;
    color: #ffffff;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #1a3e8c;
    box-shadow: 0 4px 10px rgba(34, 74, 190, 0.3);
}

a.btn:hover {
    
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(33, 150, 243, 0.4);
    text-decoration: none;
    
}

a {
    
}

.btn-block {
    width: 100%;
}

/* Ukuran lebih kecil untuk logo */
.logo-small {
    width: 60px; /* Ukuran logo lebih kecil */
    height: auto; /* Menyesuaikan tinggi secara proporsional */
}

/* Ukuran lebih kecil untuk auth-title */
.title-small {
    font-size: 18px; /* Ukuran font lebih kecil */
    font-weight: bold;
    color: #224abe;
    margin-bottom: 8px;
}




/* Responsive Styles */
@media (max-width: 768px) {
    #auth {
        flex-direction: column;
    }

    #auth-left, #auth-right {
        width: 100%;
        border-radius: 0;
    }

    #auth-left {
        padding: 20px;
    }

    .auth-title {
        font-size: 20px;
    }

    .auth-subtitle {
        font-size: 12px;
    }

    .btn-primary {
        font-size: 12px;
    }
}

@media (min-width: 768px) {
  .dashboard-header:hover {
    box-shadow: 0 12px 32px rgba(33, 150, 243, 0.15);
    transform: translateY(-2px);
  }
}
</style>


