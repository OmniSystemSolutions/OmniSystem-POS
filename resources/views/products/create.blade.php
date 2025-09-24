@extends('layouts.app')
@section('content')
<div class="main-content">
   <div>
      <div class="breadcrumb">
         <h1 class="mr-3">Create Product</h1>
         <ul>
            <li><a href=""> Inventory </a></li>
            <!----> <!---->
         </ul>
         <div class="breadcrumb-action"></div>
      </div>
      <div class="separator-breadcrumb border-top"></div>
   </div>
   <!----> 
   <div class="wrapper">
      <span>
         <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="row">
               <div class="top-wrapper" style="display: none;">
               </div>
               <div class="col-sm-12">
                  <div class="row">
                     <div class="mt-3 col-md-8">
                        <div class="card">
                           <!----><!---->
                           <div class="card-body">
                              <!----><!---->
                              <div class="row">
                                 <div class="col-md-6">
                                    <span>
                                       <fieldset class="form-group" id="__BVID__358">
                                          <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="__BVID__358__BV_label_">SKU(Product Code) *</legend>
                                          <div>
                                             <input type="text" placeholder="Enter SKU" class="form-control" aria-describedby="Name-feedback" label="Name" id="code" name="code" value="{{ old('CODE') }}"> 
                                             <div id="SKU-feedback" class="invalid-feedback"></div>
                                          </div>
                                       </fieldset>
                                    </span>

                                       <!-- Category select + New button -->
                              <div class="form-group">
                                 <label for="category_id">Category</label>
                                 <div class="d-flex">
                                       <select name="category_id" id="category_id" class="form-control mr-2">
                                          @foreach ($categories as $category)
                                             <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                   {{ $category->name }}
                                             </option>
                                          @endforeach
                                       </select>
                                       <button type="button" id="toggleCategoryBtn" class="btn btn-outline-success btn-sm" onclick="toggleCategoryForm()">
                                          <i class="i-Add"></i>
                                       </button>
                                 </div>
                              </div>

                              <!-- Inline new category form (hidden) -->
                              <div id="newCategoryForm" class="border rounded p-4 mt-3 bg-white shadow-sm" style="display:none; max-width:600px; margin:auto;">
                                 <h4 class="text-center mb-4">Add Category</h4>

                                 <div class="form-group">
                                       <label for="new_category_name" class="font-weight-bold">Category Name *</label>
                                       <input type="text" id="new_category_name" class="form-control" placeholder="Enter category name">
                                       <div class="invalid-feedback" id="err_new_category_name"></div>
                                 </div>

                                 <div class="form-group mt-3">
                                       <label for="new_category_description" class="font-weight-bold">Description</label>
                                       <textarea id="new_category_description" class="form-control" rows="3" placeholder="Enter category description"></textarea>
                                       <div class="invalid-feedback" id="err_new_category_description"></div>
                                 </div>

                                 <div class="d-flex justify-content-center mt-4">
                                       <button type="button" onclick="saveCategory()" class="btn btn-success px-4 mr-2">Save</button>
                                       <button type="button" onclick="toggleCategoryForm()" class="btn btn-danger px-4">Cancel</button>
                                 </div>
                              </div>

                              <!-- JS: improved fetch + error handling -->
                              <script>
                              function toggleCategoryForm() {
                                 const form = document.getElementById('newCategoryForm');
                                 form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
                                 clearCategoryFormErrors();
                              }

                              function clearCategoryFormErrors() {
                                 document.getElementById('new_category_name').classList.remove('is-invalid');
                                 document.getElementById('new_category_description').classList.remove('is-invalid');
                                 document.getElementById('err_new_category_name').innerText = '';
                                 document.getElementById('err_new_category_description').innerText = '';
                              }

                              async function saveCategory() {
                                 clearCategoryFormErrors();

                                 const name = document.getElementById('new_category_name').value.trim();
                                 const description = document.getElementById('new_category_description').value.trim();

                                 if (!name) {
                                       document.getElementById('new_category_name').classList.add('is-invalid');
                                       document.getElementById('err_new_category_name').innerText = 'Name is required.';
                                       return;
                                 }

                                 try {
                                       const res = await fetch("{{ route('categories.store') }}", {
                                          method: "POST",
                                          headers: {
                                             "Content-Type": "application/json",
                                             "Accept": "application/json",                 // <-- important so Laravel returns JSON
                                             "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                             "X-Requested-With": "XMLHttpRequest"         // <-- helps Laravel detect AJAX
                                          },
                                          body: JSON.stringify({ name, description })
                                       });

                                       // attempt to parse JSON if server returns JSON
                                       const contentType = res.headers.get('content-type') || '';
                                       const data = contentType.includes('application/json') ? await res.json() : null;

                                       if (!res.ok) {
                                          // Validation errors (Laravel returns 422 with { errors: { field: [...] } })
                                          if (res.status === 422 && data && data.errors) {
                                             showValidationErrors(data.errors);
                                             return;
                                          }
                                          // Other errors: show friendly message
                                          const msg = (data && data.message) ? data.message : res.statusText || 'Server error';
                                          throw new Error(msg);
                                       }

                                       // Success: data should be object with id, name, etc.
                                       const category = (data && data.id) ? data : null;
                                       if (!category) {
                                          // fallback if server returned entire model
                                          Swal.fire('Success', 'Category created', 'success');
                                       } else {
                                          // add new category to select and auto-select it
                                          const select = document.getElementById('category_id');
                                          const option = new Option(category.name, category.id, true, true);
                                          select.add(option);
                                          // hide + reset form
                                          document.getElementById('new_category_name').value = '';
                                          document.getElementById('new_category_description').value = '';
                                          toggleCategoryForm();

                                          Swal.fire({
                                             icon: 'success',
                                             title: 'Category created',
                                             text: category.name,
                                             timer: 1500,
                                             showConfirmButton: false
                                          });
                                       }
                                 } catch (err) {
                                       console.error('Category create error:', err);
                                       Swal.fire('Error', 'Something went wrong: ' + err.message, 'error');
                                 }
                              }

                              function showValidationErrors(errors) {
                                 // errors is an object keyed by field name, e.g. { name: ["..."], description: ["..."] }
                                 for (const [field, messages] of Object.entries(errors)) {
                                       const input = document.getElementById('new_category_' + field);
                                       const feedback = document.getElementById('err_new_category_' + field);
                                       if (input) input.classList.add('is-invalid');
                                       if (feedback) feedback.innerText = messages.join(' ');
                                 }
                              }
                              </script>

                                    <span>
                                       <fieldset class="form-group" id="__BVID__408">
                                          <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="__BVID__408__BV_label_">Unit Price *</legend>
                                          <div>
                                             <input class="form-control" aria-describedby="Price-feedback" placeholder="0" name="price" value="{{ old('PRICE') }}" inputmode="decimal"> 
                                             <div id="Price-feedback" class="invalid-feedback"></div>
                                             <!----><!----><!---->
                                          </div>
                                       </fieldset>
                                    </span>

                                    
                                 </div>
                                 <div class="col-md-6">
                                    <span>
                                       <fieldset class="form-group" id="__BVID__3161">
                                          <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="__BVID__3161__BV_label_">Product Name *</legend>
                                          <div>
                                          <input type="text" placeholder="Enter Name of Product" class="form-control" aria-describedby="Name-feedback" label="Name" id="name" name="name" value="{{ old('NAME') }}"> 
                                             <div id="Name-feedback" class="invalid-feedback"></div>
                                          </div>
                                       </fieldset>
                                    </span>
                  <!-- Subcategory select + New button -->
                  <div class="form-group">
                     <label for="subcategory_id">Subcategory</label>
                     <div class="d-flex">
                           <select name="subcategory_id" id="subcategory_id" class="form-control mr-2">
                              {{-- no default placeholder, will be filled dynamically --}}
                           </select>
                           <button type="button" id="toggleSubCategoryBtn" class="btn btn-outline-success btn-sm" onclick="toggleSubCategoryForm()">
                              <i class="i-Add"></i>
                           </button>
                     </div>
                  </div>


                  <script>
                  document.getElementById('category_id').addEventListener('change', async function () {
                     const categoryId = this.value;
                     const subcategorySelect = document.getElementById('subcategory_id');
                     
                     // Clear options (no placeholder this time)
                     subcategorySelect.innerHTML = '';

                     if (!categoryId) return;

                     try {
                           const res = await fetch(`/categories/${categoryId}/subcategories`);
                           const subcategories = await res.json();

                           // Get old value from Blade
                           const oldSubcategoryId = "{{ old('subcategory_id') }}";

                           subcategories.forEach(sub => {
                              const option = new Option(sub.name, sub.id);

                              // Auto-select if matches old value
                              if (oldSubcategoryId && oldSubcategoryId == sub.id) {
                                 option.selected = true;
                              }

                              subcategorySelect.add(option);
                           });

                           // If no old value, select the first subcategory by default
                           if (!oldSubcategoryId && subcategories.length > 0) {
                              subcategorySelect.options[0].selected = true;
                           }
                     } catch (err) {
                           console.error('Failed to load subcategories:', err);
                     }
                  });

                  // Auto-load subcategories if category is pre-selected
                  document.addEventListener('DOMContentLoaded', () => {
                     const selectedCategory = document.getElementById('category_id').value;
                     if (selectedCategory) {
                           document.getElementById('category_id').dispatchEvent(new Event('change'));
                     }
                  });
                  </script>


                              <!-- Inline new subcategory form (hidden) -->
                              <div id="newSubCategoryForm" class="border rounded p-4 mt-3 bg-white shadow-sm" style="display:none; max-width:600px; margin:auto;">
                                 <h4 class="text-center mb-4">Add Sub Category</h4>

                                 <div class="form-group">
                                       <label for="new_subcategory_name" class="font-weight-bold">Subcategory Name *</label>
                                       <input type="text" id="new_subcategory_name" class="form-control" placeholder="Enter subcategory name">
                                       <div class="invalid-feedback" id="err_new_subcategory_name"></div>
                                 </div>

                                 <div class="form-group mt-3">
                                       <label for="new_subcategory_description" class="font-weight-bold">Description</label>
                                       <textarea id="new_subcategory_description" class="form-control" rows="3" placeholder="Enter subcategory description"></textarea>
                                       <div class="invalid-feedback" id="err_new_subcategory_description"></div>
                                 </div>

                                 <div class="d-flex justify-content-center mt-4">
                                       <button type="button" onclick="saveSubCategory()" class="btn btn-success px-4 mr-2">Save</button>
                                       <button type="button" onclick="toggleSubCategoryForm()" class="btn btn-danger px-4">Cancel</button>
                                 </div>
                              </div>

                              <script>
                              function toggleSubCategoryForm() {
                                 const form = document.getElementById('newSubCategoryForm');
                                 form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
                                 clearSubCategoryFormErrors();
                              }

                              function clearSubCategoryFormErrors() {
                                 document.getElementById('new_subcategory_name').classList.remove('is-invalid');
                                 document.getElementById('new_subcategory_description').classList.remove('is-invalid');
                                 document.getElementById('err_new_subcategory_name').innerText = '';
                                 document.getElementById('err_new_subcategory_description').innerText = '';
                              }

                              async function saveSubCategory() {
                                 clearSubCategoryFormErrors();

                                 const name = document.getElementById('new_subcategory_name').value.trim();
                                 const description = document.getElementById('new_subcategory_description').value.trim();
                                 const category_id = document.getElementById('category_id').value; // parent category selected

                                 if (!name) {
                                       document.getElementById('new_subcategory_name').classList.add('is-invalid');
                                       document.getElementById('err_new_subcategory_name').innerText = 'Name is required.';
                                       return;
                                 }

                                 if (!category_id) {
                                       Swal.fire('Error', 'Please select a parent category first.', 'error');
                                       return;
                                 }

                                 try {
                                       const res = await fetch("{{ route('subcategories.store') }}", {
                                          method: "POST",
                                          headers: {
                                             "Content-Type": "application/json",
                                             "Accept": "application/json",
                                             "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                             "X-Requested-With": "XMLHttpRequest"
                                          },
                                          body: JSON.stringify({ name, description, category_id })
                                       });

                                       const contentType = res.headers.get('content-type') || '';
                                       const data = contentType.includes('application/json') ? await res.json() : null;

                                       if (!res.ok) {
                                          if (res.status === 422 && data && data.errors) {
                                             showSubCategoryValidationErrors(data.errors);
                                             return;
                                          }
                                          const msg = (data && data.message) ? data.message : res.statusText || 'Server error';
                                          throw new Error(msg);
                                       }

                                       const subcategory = (data && data.id) ? data : null;
                                       if (!subcategory) {
                                          Swal.fire('Success', 'Subcategory created', 'success');
                                       } else {
                                          const select = document.getElementById('subcategory_id');
                                          const option = new Option(subcategory.name, subcategory.id, true, true);
                                          select.add(option);
                                          document.getElementById('new_subcategory_name').value = '';
                                          document.getElementById('new_subcategory_description').value = '';
                                          toggleSubCategoryForm();

                                          Swal.fire({
                                             icon: 'success',
                                             title: 'Subcategory created',
                                             text: subcategory.name,
                                             timer: 1500,
                                             showConfirmButton: false
                                          });
                                       }
                                 } catch (err) {
                                       console.error('SubCategory create error:', err);
                                       Swal.fire('Error', 'Something went wrong: ' + err.message, 'error');
                                 }
                              }

                              function showSubCategoryValidationErrors(errors) {
                                 for (const [field, messages] of Object.entries(errors)) {
                                       const input = document.getElementById('new_subcategory_' + field);
                                       const feedback = document.getElementById('err_new_subcategory_' + field);
                                       if (input) input.classList.add('is-invalid');
                                       if (feedback) feedback.innerText = messages.join(' ');
                                 }
                              }
                              </script>
                                 </div>
                           <!----><!---->
                        </div>

      <div class="row">

         <div class="col-md-12 mt-4">
               <!-- Recipe Table -->
               <h5>Ingredients</h5>
               <table class="table table-bordered" id="recipeTable">
                  <thead>
                     <tr>
                           <th>Component</th>
                           <th>Quantity</th>
                           <th>Unit</th>
                           <th>Cost</th>
                           <th><button type="button" class="btn btn-success btn-sm" onclick="addRecipeRow()">+</button></th>
                     </tr>
                  </thead>
                  <tbody>
                     <!-- Dynamic rows here -->
                  </tbody>
               </table>

               <!-- 🔥 Total Cost Row -->
               <div class="row mt-2">
                  <div class="col-md-9 text-right">
                     <label><strong>Total Cost:</strong></label>
                  </div>
                  <div class="col-md-2">
                     <input type="text" id="totalCost" class="form-control" value="0.00" readonly>
                  </div>
               </div>
         </div>
      </div>


            <div class="mt-3 col-md-12">
                  <div class="mr-2">
                     <div class="b-overlay-wrap position-relative d-inline-block btn-loader">
                     <button type="submit" class="btn btn-primary mt-3">Save Product</button>
                     </div>
                  </div>
               </div>
            </div>
</form>

   <script>
   let components = @json(App\Models\Component::all()); // Load all components for dropdown

   function addRecipeRow() {
         const tbody = document.querySelector('#recipeTable tbody');
         const tr = document.createElement('tr');

         const componentOptions = components.map(c =>
            `<option value="${c.id}" data-cost="${c.cost}">${c.name}</option>`
         ).join('');

         tr.innerHTML = `
            <td>
                  <select name="recipes[component_id][]" class="form-control component-select" required>
                     ${componentOptions}
                  </select>
            </td>
            <td><input type="number" name="recipes[quantity][]" class="form-control recipe-quantity" step="0.01" required></td>
            <td><input type="text" name="recipes[unit][]" class="form-control" required></td>
            <td><input type="text" name="recipes[cost][]" class="form-control component-cost" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">x</button></td>
         `;

         tbody.appendChild(tr);

         // 🔍 turn the new select into a Select2 searchable dropdown
         $(tr).find('.component-select').select2({
            width: '100%'
         });

         const select = tr.querySelector('.component-select');
         const quantityInput = tr.querySelector('.recipe-quantity');
         const costInput = tr.querySelector('.component-cost');
         const removeBtn = tr.querySelector('.remove-row');

         function updateCost() {
            const selectedOption = select.options[select.selectedIndex];
            const baseCost = parseFloat(selectedOption.getAttribute('data-cost')) || 0;
            const qty = parseFloat(quantityInput.value) || 0;
            costInput.value = qty > 0 ? (baseCost * qty).toFixed(2) : '';
            updateTotalCost(); // 🔥 recalc total every time
         }

         select.addEventListener('change', updateCost);
         quantityInput.addEventListener('input', updateCost);

         // remove row + recalc total
         removeBtn.addEventListener('click', function () {
            tr.remove();
            updateTotalCost();
         });
   }

   // 🔥 Function to calculate grand total
   function updateTotalCost() {
         let total = 0;
         document.querySelectorAll('.component-cost').forEach(input => {
            total += parseFloat(input.value) || 0;
         });
         document.querySelector('#totalCost').value = total.toFixed(2); // ✅ fixed
   }

   // Add one default row
   document.addEventListener('DOMContentLoaded', addRecipeRow);
   </script>

      <div class="row">
   </form>
</span>
</div>
</div>
@endsection