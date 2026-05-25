<!DOCTYPE html>
<html>

<head>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('css/table.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15/dist/nouislider.min.css">

  <!-- Toastify -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.7.11/fabric.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/nouislider@15/dist/nouislider.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue2-daterange-picker/dist/vue2-daterange-picker.css">

  <!-- Perfect Scrollbar -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/css/perfect-scrollbar.min.css" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>

  <!-- Vue -->
  <script src="https://unpkg.com/vue@2.7.14/dist/vue.js"></script>

  <!-- Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Popper -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

  <!-- XLSX -->
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

  <!-- Date Range Picker -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue2-daterange-picker@0.6.8/dist/vue2-daterange-picker.css">

  <script src="https://cdn.jsdelivr.net/npm/vue2-daterange-picker/dist/vue2-daterange-picker.min.js"></script>

  <!-- Vue Select -->
  <link rel="stylesheet" href="https://unpkg.com/vue-select@3.20.2/dist/vue-select.css">

  <script src="https://unpkg.com/vue-select@3.20.2"></script>

  <!-- BootstrapVue -->
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-vue@2.23.1/dist/bootstrap-vue.min.css">

  <script src="https://unpkg.com/bootstrap-vue@2.23.1/dist/bootstrap-vue.min.js"></script>

  <!-- Flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<style>
  .vs__dropdown-toggle {
    cursor: pointer;
    position: relative;
  }

  .vs__open-indicator {
    transition: transform 0.2s ease;
  }

  .vs__open-indicator.rotate {
    transform: rotate(180deg);
  }

  .vs__listbox {
    border: 1px solid #ccc;
    margin-top: 4px;
    list-style: none;
    padding: 0;
    display: none;
    max-height: 200px;
    overflow-y: auto;
    background: white;
    position: absolute;
    width: 100%;
    z-index: 1000;
  }

  .vs__listbox li {
    padding: 6px 10px;
    cursor: pointer;
  }

  .vs__listbox li:hover {
    background: #f0f0f0;
  }
</style>

<body>

  @php
  $user = Auth::user();
  @endphp

  @include('layouts.header')
  @include('layouts.sidebar')

  <main>
    <div class="main-content-wrap d-flex flex-column flex-grow-1 sidenav-open">

      @yield('content')

      @include('layouts.footer')

    </div>
  </main>

  @yield('scripts')

  @stack('scripts')

  <!-- Toastify -->
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <script>
    // Axios CSRF
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute('content');

    // Reusable Toast Function
    function showToast(message, type = 'success') {

      let bgColor = '#22c55e';
      let icon = '✔';

      if (type === 'error') {
        bgColor = '#ef4444';
        icon = '✖';
      }

      if (type === 'warning') {
        bgColor = '#f59e0b';
        icon = '⚠';
      }

      if (type === 'info') {
        bgColor = '#3b82f6';
        icon = 'ℹ';
      }

      Toastify({
        text: `${icon}  ${message}`,
        duration: 3500,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        close: true,

        style: {
          background: bgColor,
          borderRadius: "12px",
          padding: "14px 18px",
          fontSize: "14px",
          fontWeight: "500",
          boxShadow: "0 8px 24px rgba(0,0,0,0.15)",
          minWidth: "320px",
          maxWidth: "420px",
        },

      }).showToast();
    }
  </script>

</body>

</html>