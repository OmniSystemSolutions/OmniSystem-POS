@extends('layouts.app')
@section('content')
<div class="main-content">
    <div class="breadcrumb">
        <h1>User Permission</h1>
        <ul>
            <li><a href="{{ route('settings.index') }}">Settings</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="wrapper">
   <div class="card">
      <!----><!---->
      <div class="card-body">
         <!----><!---->
         <div class="vgt-wrap ">
            <!----> 
            <div class="vgt-inner-wrap">
               <!----> 
               <div class="vgt-global-search vgt-clearfix">
                  <div class="vgt-global-search__input vgt-pull-left">
                     <form role="search">
                        <label for="vgt-search-381467791115">
                           <span aria-hidden="true" class="input__icon">
                              <div class="magnifying-glass"></div>
                           </span>
                           <span class="sr-only">Search</span>
                        </label>
                        <input id="vgt-search-381467791115" type="text" placeholder="Search this table" class="vgt-input vgt-pull-left">
                     </form>
                  </div>
                  <div class="vgt-global-search__actions vgt-pull-right">
                     <div class="mt-2 mb-3"><button type="button" class="btn btn-outline-success ripple m-1 btn-sm"><i class="i-File-Copy"></i> PDF
                        </button> <button class="btn btn-sm btn-outline-danger ripple m-1"><i class="i-File-Excel"></i> EXCEL
                        </button> <a href="permission/create" class="btn-rounded btn btn-primary btn-icon m-1"><i class="i-Add"></i>
                        Add
                        </a>
                     </div>
                  </div>
               </div>
               <!----> 
               <div class="vgt-fixed-header">
                  <!---->
               </div>
               <div class="vgt-responsive">
                  <table id="vgt-table" class="table-hover tableOne vgt-table ">
                     <colgroup>
                        <col id="col-0">
                        <col id="col-1">
                        <col id="col-2">
                     </colgroup>
                     <thead>
                        <tr>
                           <!----> 
                           <th scope="col" class="vgt-checkbox-col"><input type="checkbox"></th>
                           <th scope="col" aria-sort="descending" aria-controls="col-0" class="vgt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Name</span> <button><span class="sr-only">
                              Sort table by Name in descending order
                              </span></button>
                           </th>
                           <th scope="col" aria-sort="descending" aria-controls="col-1" class="vgt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Description</span> <button><span class="sr-only">
                              Sort table by Description in descending order
                              </span></button>
                           </th>
                           <th scope="col" aria-sort="descending" aria-controls="col-2" class="vgt-left-align text-right" style="min-width: auto; width: auto;">
                              <span>Action</span> <!---->
                           </th>
                        </tr>
                        <!---->
                     </thead>
                     <tbody>
                        @foreach ($roles as $role)
                <tr>
                    <th class="vgt-checkbox-col">
                        <input type="checkbox" name="selected_roles[]" value="{{ $role->id }}">
                    </th>
                    <td class="text-left">{{ $role->name }}</td>
                    <td class="text-left">{{ $role->description ?? '—' }}</td>
                    <td class="text-right">
                        @include('layouts.actions-dropdown', [
                            'id' => $role->id,
                            'editRoute' => route('permissions.edit', $role->id),
                            'deleteRoute' => route('permissions.delete', $role->id),
                            'logsRoute' => '#',
                            'remarksRoute' => '#',
                        ])
                    </td>
                </tr>
            @endforeach
                     </tbody>
                     <!---->
                  </table>
               </div>
               <!----> 
               <div class="vgt-wrap__footer vgt-clearfix">
                  <div class="footer__row-count vgt-pull-left">
                     <form>
                        <label for="vgt-select-rpp-1607445973413" class="footer__row-count__label">Rows per page:</label> 
                        <select id="vgt-select-rpp-1607445973413" autocomplete="off" name="perPageSelect" aria-controls="vgt-table" class="footer__row-count__select">
                           <option value="10">
                              10
                           </option>
                           <option value="20">
                              20
                           </option>
                           <option value="30">
                              30
                           </option>
                           <option value="40">
                              40
                           </option>
                           <option value="50">
                              50
                           </option>
                           <option value="-1">All</option>
                        </select>
                     </form>
                  </div>
                  <div class="footer__navigation vgt-pull-right">
                     <div data-v-347cbcfa="" class="footer__navigation__page-info">
                        <div data-v-347cbcfa="">
                           1 - 10 of 32
                        </div>
                     </div>
                     <!----> <button type="button" aria-controls="vgt-table" class="footer__navigation__page-btn disabled"><span aria-hidden="true" class="chevron left"></span> <span>prev</span></button> <button type="button" aria-controls="vgt-table" class="footer__navigation__page-btn"><span>next</span> <span aria-hidden="true" class="chevron right"></span></button> <!---->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!----><!---->
   </div>
</div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.swal-confirm').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // prevent normal form submit

        Swal.fire({
            title: form.dataset.title || 'Are you sure?',
            text: form.dataset.text || '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: form.dataset.confirmButton || 'Yes, delete!',
        }).then((result) => {
            if (result.isConfirmed) {

                // Use AJAX to submit form
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                })
                .then(response => response.json())
                .then(data => {
                    // ✅ Show success alert
                    Swal.fire({
                        title: 'Deleted!',
                        text: data.message || 'Record has been deleted.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Optional: remove row from table without reload
                        form.closest('tr')?.remove();
                    });
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Error', 'Something went wrong!', 'error');
                });

            }
        });
    });
});
</script>
@endsection

