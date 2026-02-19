@extends('layouts.app')

@section('content')
<style>
    .upload-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

#drop-area {
    cursor: pointer;
    width: 100%;
    max-width: 350px;
}

#drop-area p {
    white-space: pre-line; /* preserves \n line breaks */
}

</style>
<div id="app" class="main-content">
    <div class="breadcrumb">
        <h1>@{{ isEdit ? 'Update Bundle Product' : 'Create Bundle Product' }}</h1>
    </div>
    <div class="card mt-4">
        <div class="card-body">
        <form @submit.prevent="submitForm">
            <div class="col-sm-12">
                <div class="row">
                    <div class="mt-3 col-md-8">
                    {{-- 
                    <div class="card">
                        <!----><!---->
                        <div class="card-body">
                            --}}
                            <!----><!---->
                            <div class="row">
                                <div class="col-md-6">
                                <span>
                                    <fieldset class="form-group" id="__BVID__358">
                                        <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="__BVID__358__BV_label_">SKU(Product Code)</legend>
                                        <div>
                                            <input type="text" placeholder="Enter SKU" class="form-control" aria-describedby="Name-feedback" label="Name" id="code" v-model="form.code"> 
                                            <div id="SKU-feedback" class="invalid-feedback"></div>
                                        </div>
                                    </fieldset>
                                </span>
                                <div class="form-group">
                                    <label>Category</label>
                                    <div class="d-flex">
                                        <select class="custom-select mr-2"
                                            v-model="form.category_id">
                                            <option disabled value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <button type="button"
                                            class="btn btn-outline-success btn-sm"
                                            @click="showCategoryForm = !showCategoryForm">
                                        <i class="i-Add"></i>
                                        </button>
                                    </div>
                                </div>
                                <div v-if="showCategoryForm"
                                    class="border rounded p-4 mt-3 bg-white shadow-sm">
                                    <h4 class="text-center mb-4">Add Category</h4>
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text"
                                            class="form-control"
                                            v-model="newCategory.name"
                                            :class="{'is-invalid': errors.name}">
                                        <div class="invalid-feedback">@{{ errors.name }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control"
                                            v-model="newCategory.description"></textarea>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button class="btn btn-success mr-2"
                                            @click="saveCategory">
                                        Save
                                        </button>
                                        <button class="btn btn-danger"
                                            @click="showCategoryForm = false">
                                        Cancel
                                        </button>
                                    </div>
                                </div>
                                <span>
                                    <fieldset class="form-group" id="__BVID__408">
                                        <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="__BVID__408__BV_label_">Unit Price</legend>
                                        <div>
                                            <input class="form-control" aria-describedby="Price-feedback" placeholder="0" v-model="form.price" inputmode="decimal"> 
                                            <div id="Price-feedback" class="invalid-feedback"></div>
                                            <!----><!----><!---->
                                        </div>
                                    </fieldset>
                                </span>
                                <span>
                                    <fieldset class="form-group" id="__BVID__408">
                                        <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="__BVID__408__BV_label_">Quantity</legend>
                                        <div>
                                            <input class="form-control" aria-describedby="Quantity-feedback" placeholder="0" v-model="form.quantity" inputmode="decimal"> 
                                            <div id="Quantity-feedback" class="invalid-feedback"></div>
                                            <!----><!----><!---->
                                        </div>
                                    </fieldset>
                                </span>
                                </div>
                                <div class="col-md-6">
                                <span>
                                    <fieldset class="form-group" id="__BVID__3161">
                                        <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0" id="__BVID__3161__BV_label_">Product Name</legend>
                                        <div>
                                            <input type="text" placeholder="Enter Name of Product" class="form-control" aria-describedby="Name-feedback" label="Name" id="name" v-model="form.name"> 
                                            <div id="Name-feedback" class="invalid-feedback"></div>
                                        </div>
                                    </fieldset>
                                </span>
                                <!-- Subcategory select + New button -->
                                <div class="form-group mt-3">
                                    <label for="subcategory_id">Subcategory</label>
                                    <div class="d-flex">
                                        <select class="custom-select mr-2" v-model="form.subcategory_id">
                                            <option value="" disabled selected>Select Subcategory</option>
                                            <option v-for="sub in form.subcategories" :key="sub.id" :value="sub.id">
                                            @{{ sub.name }}
                                            </option>
                                        </select>
                                        <button type="button" class="btn btn-outline-success btn-sm" @click="toggleSubCategoryForm">
                                        <i class="i-Add"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Inline New Subcategory Form -->
                                <div v-if="showSubCategoryForm" class="border rounded p-4 mt-3 bg-white shadow-sm" style="max-width:600px; margin:auto;">
                                    <h4 class="text-center mb-4">Add Subcategory</h4>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Subcategory Name</label>
                                        <input type="text" class="form-control" v-model="newSubCategory.name" :class="{ 'is-invalid': errors.subcategory_name }">
                                        <div class="invalid-feedback">@{{ errors.subcategory_name }}</div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea class="form-control" rows="3" v-model="newSubCategory.description" :class="{ 'is-invalid': errors.subcategory_description }"></textarea>
                                        <div class="invalid-feedback">@{{ errors.subcategory_description }}</div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="button" class="btn btn-success px-4 mr-2" @click="saveSubCategory">Save</button>
                                        <button type="button" class="btn btn-danger px-4" @click="toggleSubCategoryForm">Cancel</button>
                                    </div>
                                </div>
                                <!-- Unit select -->
                                <div class="form-group">
                                    <label for="unit_id">Unit</label>
                                    <div class="d-flex">
                                        <select v-model="form.unit_id" id="unit_id" class="form-control mr-2">
                                            <option disabled value="">Select Unit</option>
                                            @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mt-3 mt-md-0">
                                <fieldset class="form-group" style="width: 300px;">
                                <legend>Product Image</legend>
                                <div id="drop-area"
                                class="upload-box text-center p-3 border rounded position-relative"
                                @dragover.prevent
                                @drop.prevent="handleDrop"
                                @click="triggerFileInput">
                                <!-- Hidden File Input -->
                                <input type="file"
                                    ref="fileInput"
                                    class="d-none"
                                    @change="onFileChange"
                                    accept=".png, .jpg, .jpeg">
                                <!-- If NO image -->
                                <div v-if="!form.previewImage">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-muted"></i>
                                    <p class="text-muted mb-0">
                                        Drag & Drop an image<br>
                                        <strong>(or) Click to select</strong>
                                    </p>
                                </div>
                                <!-- If image EXISTS -->
                                <div v-else class="preview-wrapper">
                                    <img :src="form.previewImage" class="preview-image">
                                    <div class="overlay-text">
                                        Click to change image
                                    </div>
                                </div>
                            </div>
                        </div>
                        </fieldset>        
                    </div>
                    </div>
                    <hr>
                    <h5>Ingredients</h5>
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="120">Type</th>
                            <th>Item</th>
                            <th width="150">Qty</th>
                            <th width="100">
                                <button type="button" class="btn btn-success btn-sm" @click="addItem">+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in form.items" :key="index">
                            <!-- Type Selector -->
                            <td>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" :name="'type-'+index" value="product" v-model="item.type">
                                <label class="form-check-label">Product</label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" :name="'type-'+index" value="component" v-model="item.type">
                                <label class="form-check-label">Component</label>
                                </div>
                            </td>
                            <!-- Item Select -->
                            <td>
                                <select class="form-control" v-model="item.product_id">
                                <option disabled value="">Select</option>
                                <optgroup label="Products" v-if="item.type === 'product'">
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Components" v-if="item.type === 'component'">
                                    @foreach(App\Models\Component::where('for_sale', true)->get() as $component)
                                        <option value="{{ $component->id }}">
                                            {{ $component->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                                </select>
                            </td>
                            <!-- Quantity -->
                            <td>
                                <input type="number" class="form-control" v-model="item.quantity">
                            </td>
                            <!-- Remove Button -->
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" @click="removeItem(index)">x</button>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                    <button class="btn btn-primary mt-3">
                    @{{ isEdit ? 'Update Bundle' : 'Create Bundle' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
new Vue({
    el: '#app',

    data: {
        isEdit: {!! $bundle ? 'true' : 'false' !!},
        form: {
            id: {!! $bundle->id ?? 'null' !!},
            name: @json($bundle->name ?? ''),
            code: @json($bundle->code ?? ''),
            price: @json($bundle->price ?? ''),
            category_id: @json($bundle->category_id ?? ''),
            subcategory_id: @json($bundle->subcategory_id ?? ''),
            subcategories: [],
            unit_id: @json($bundle->unit_id ?? ''),
            quantity: @json($bundle->quantity ?? ''),
            image: null,          
            previewImage: @json($bundle && $bundle->image ? asset('storage/'.$bundle->image) : null), 
            items: @json(
                $bundle
                    ? $bundle->bundleItems->map(fn($item) => [
                        'type' => $item->item_type,
                        'product_id' => $item->item_id,
                        'quantity' => $item->
                        quantity
                    ])
                    : []
            ),
            
        },
        showCategoryForm: false,
        showSubCategoryForm: false,
        allSubcategories: @json($subcategories),
        newCategory: { name: '', description: '' },
        newSubCategory: { name: '', description: '' },
        errors: {}
    },

    methods: {
         triggerFileInput() {
        this.$refs.fileInput.click();
    },

    onFileChange(event) {
    const file = event.target.files[0];
    if (!file) return;

    const validTypes = ['image/png', 'image/jpeg'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    // Validate file type
    if (!validTypes.includes(file.type)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid File Type',
            text: 'Only PNG and JPG files are allowed.',
            confirmButtonColor: '#3085d6'
        });

        event.target.value = '';
        return;
    }

    // Validate file size
    if (file.size > maxSize) {
        Swal.fire({
            icon: 'warning',
            title: 'File Too Large',
            text: 'Image must not exceed 2MB.',
            confirmButtonColor: '#3085d6'
        });

        event.target.value = '';
        return;
    }

    // Save file
    this.form.image = file;

    // Preview
    const reader = new FileReader();
    reader.onload = e => {
        this.form.previewImage = e.target.result;
    };
    reader.readAsDataURL(file);
},

    handleDrop(event) {
    const file = event.dataTransfer.files[0];
    if (!file) return;

    const validTypes = ['image/png', 'image/jpeg'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (!validTypes.includes(file.type)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid File Type',
            text: 'Only PNG and JPG files are allowed.'
        });
        return;
    }

    if (file.size > maxSize) {
        Swal.fire({
            icon: 'warning',
            title: 'File Too Large',
            text: 'Image must not exceed 2MB.'
        });
        return;
    }

    this.form.image = file;

    const reader = new FileReader();
    reader.onload = e => {
        this.form.previewImage = e.target.result;
    };
    reader.readAsDataURL(file);
},
        toggleCategoryForm() {
            this.showCategoryForm = !this.showCategoryForm;
            this.clearCategoryErrors();
        },
        toggleSubCategoryForm() {
            this.showSubCategoryForm = !this.showSubCategoryForm;
            this.clearSubCategoryErrors();
        },
        clearCategoryErrors() {
            this.errors = {};
            this.newCategory.name = '';
            this.newCategory.description = '';
        },
        clearSubCategoryErrors() {
            this.errors.subcategory_name = '';
            this.errors.subcategory_description = '';
            this.newSubCategory.name = '';
            this.newSubCategory.description = '';
        },
        async saveCategory() {
            this.errors = {};
            if (!this.newCategory.name.trim()) {
                this.errors.name = 'Name is required.';
                return;
            }
            try {
                const res = await fetch("{{ route('categories.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.newCategory)
                });
                const data = await res.json();
                if (!res.ok) throw data;

                // Add to select
                const option = { id: data.id, name: data.name };
                this.$set(this.form, 'categories', [...(this.form.categories || []), option]);
                this.form.category_id = data.id;
                this.toggleCategoryForm();
                Swal.fire('Success', 'Category created', 'success');
            } catch (err) {
                this.errors = err.errors || { name: err.message || 'Something went wrong' };
            }
        },
        async saveSubCategory() {
            this.errors = {};
            if (!this.newSubCategory.name.trim()) {
                this.errors.subcategory_name = 'Name is required.';
                return;
            }
            if (!this.form.category_id) {
                Swal.fire('Error', 'Please select a parent category first.', 'error');
                return;
            }
            try {
                const res = await fetch("{{ route('subcategories.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: this.newSubCategory.name,
                        description: this.newSubCategory.description,
                        category_id: this.form.category_id
                    })
                });
                const data = await res.json();
                if (!res.ok) throw data;

                // Add to subcategory list
                this.form.subcategories.push({ id: data.id, name: data.name });
                this.form.subcategory_id = data.id;
                this.toggleSubCategoryForm();
                Swal.fire({ icon: 'success', title: 'Subcategory created', timer: 1500, showConfirmButton: false });
            } catch (err) {
                this.errors.subcategory_name = err.errors?.name?.[0] || err.message || 'Something went wrong';
            }
        },

        addItem() {
            this.form.items.push({
                type: 'product',
                product_id: '',
                quantity: 1
            });
        },

        removeItem(index) {
            this.form.items.splice(index, 1);
        },

        submitForm() {
    // Determine URL and method
    let url = this.isEdit
        ? `/bundled-items/${this.form.id}`  // Edit
        : `/bundled-items`;                 // Create

    let method = this.isEdit ? 'POST' : 'POST'; // For Laravel, we'll spoof PUT

    // Use FormData for files
    let formData = new FormData();

    // Append all form fields
    for (let key in this.form) {
        if (key === 'items' || key === 'subcategories') continue; // Arrays we'll handle separately
        if (this.form[key] !== null && this.form[key] !== undefined) {
            formData.append(key, this.form[key]);
        }
    }

    // Append items array
    this.form.items.forEach((item, index) => {
        formData.append(`items[${index}][type]`, item.type);
        formData.append(`items[${index}][product_id]`, item.product_id);
        formData.append(`items[${index}][quantity]`, item.quantity);
    });

    // Spoof PUT if editing
    if (this.isEdit) {
        formData.append('_method', 'PUT');
    }

    axios({
        method: 'POST', // Always POST when using FormData with _method
        url: url,
        data: formData,
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    .then(() => {
    Swal.fire({
        title: this.isEdit ? 'Updated!' : 'Created!',
        icon: 'success',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
            // Optional: show a nice loading animation before checkmark
            const b = Swal.getHtmlContainer();
            if (b) b.classList.add('swal2-toast-success'); // adds subtle styling
        }
    }).then(() => {
        // Redirect after the animation completes
        window.location.href = "/bundled-items";
    });
})
    .catch(error => {
        console.log(error);
        Swal.fire('Error', 'Validation failed', 'error');
    });
}


    },

    mounted() {
    if (!this.form.items.length) {
        this.addItem();
    }

    if (this.form.category_id) {
        // Populate subcategories that belong to the selected category
        this.form.subcategories = this.allSubcategories.filter(
            sub => sub.category_id == this.form.category_id
        );

        // Ensure selected subcategory is set
        if (this.form.subcategory_id && !this.form.subcategories.some(sub => sub.id == this.form.subcategory_id)) {
            this.form.subcategory_id = '';
        }
    }
},

     watch: {
    'form.category_id'(newVal) {
        if (!newVal) {
            this.form.subcategories = [];
            this.form.subcategory_id = '';
            return;
        }

        this.form.subcategories = this.allSubcategories.filter(
            sub => sub.category_id == newVal
        );
    }
}

});
</script>
@endsection
