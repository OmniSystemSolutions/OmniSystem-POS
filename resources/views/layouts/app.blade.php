<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/css/perfect-scrollbar.min.css" />

<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>
<!-- Vue -->
<script src="https://unpkg.com/vue@2.7.14/dist/vue.js"></script>

<!-- Vue Select -->
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.20.2/dist/vue-select.css">
<script src="https://unpkg.com/vue-select@3.20.2"></script>

</head>
<style>
  /* simple styles for dropdown list */
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
    @include('layouts.header')
    @include('layouts.sidebar')

    <main>
        <div class="main-content-wrap d-flex flex-column flex-grow-1 sidenav-open">
        @yield('content')
        @include('layouts.footer')
        </div>
    </main>
    @yield('scripts')
</body>
</html>
