@extends('layout')
@section('content')

    <section class="add_category">
        <div class="container">
            <div class="row">
                <div class="col-12  py-5">
                    <form action="{{route('products.update',$product->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p class="alert alert-danger">{{$error}}</p>
                            @endforeach
                        @endif
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="ar_title" id="floatingInput" placeholder="" value="{{json_decode($product->title)->ar}}">
                            <label for="floatingInput">Name in Arabic</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="en_title" id="floatingInput" placeholder="" value="{{json_decode($product->title)->en}}">
                            <label for="floatingInput">Name in English</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="ar_description" id="floatingInput" placeholder="" value="{{json_decode($product->description)->ar}}">
                            <label for="floatingInput">Description in Arabic</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="en_description" id="floatingInput" placeholder="" value="{{json_decode($product->description)->en}}">
                            <label for="floatingInput">Description in English</label>
                        </div>
                        <select class="form-select my-3 form-control" aria-label="Default select example" name="category" data-style="form-control"
                                data-live-search="true" >
                            <option selected >Choose Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category['id']}}" {{$category['id']==$product->category ? 'selected' : ''}}>{{$category['name']}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control my-3" name="published_by" value="{{auth()->id()}}">
                        <input type="hidden" class="form-control my-3" name="id" value="{{$product->id}}">
                        <input type="number" class="form-control my-3" name="price" placeholder="Price" value="{{$product->price}}">
                        <input type="file" accept="image/*" class="form-control my-3" name="images[]" id="images" multiple>

                        <input type="hidden" id="removedImages" name="removedImages" value="">
                        <div id="imagePreviewContainer" class="d-flex flex-wrap my-3 justify-content-center"></div>
                        <input type="submit" value="Save" class="btn btn-primary my-3 form-control">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/save_product.css')}}">
    <style>
        .image-preview {
            position: relative;
            display: inline-block;
            margin: 5px;
            border: 1px solid #eee;
        }

        .image-preview img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border-radius: 5px;
        }

        .remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
@endsection

@section('scripts')
<script>

        const imagesInput = document.getElementById('images');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const removedImagesInput = document.getElementById('removedImages');

        let dataTransfer = new DataTransfer();


        const existingImages = @json($product->images);

        if (existingImages && existingImages.length > 0) {
            existingImages.forEach((image, index) => {
                const imageDiv = document.createElement('div');
                imageDiv.classList.add('image-preview');

                const img = document.createElement('img');
                img.src = `{{ asset('images/') }}/${image.name}`;

                const removeButton = document.createElement('button');
                removeButton.classList.add('remove-image');
                removeButton.innerHTML = 'x';

                removeButton.addEventListener('click', function() {
                    imagePreviewContainer.removeChild(imageDiv);
                    removedImagesInput.value += `${image.name},`;
                });

                imageDiv.appendChild(img);
                imageDiv.appendChild(removeButton);
                imagePreviewContainer.appendChild(imageDiv);
            });
        }


        imagesInput.addEventListener('change', function(event) {
            imagePreviewContainer.innerHTML='';
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileReader = new FileReader();

                fileReader.onload = function(e) {
                    const imageUrl = e.target.result;

                    const imageDiv = document.createElement('div');
                    imageDiv.classList.add('image-preview');

                    const img = document.createElement('img');
                    img.src = imageUrl;

                    const removeButton = document.createElement('button');
                    removeButton.classList.add('remove-image');
                    removeButton.innerHTML = 'x';

                    removeButton.addEventListener('click', function() {
                        imagePreviewContainer.removeChild(imageDiv);

                        dataTransfer.items.remove(i);
                        imagesInput.files = dataTransfer.files;
                    });

                    imageDiv.appendChild(img);
                    imageDiv.appendChild(removeButton);
                    imagePreviewContainer.appendChild(imageDiv);
                };

                fileReader.readAsDataURL(file);


                dataTransfer.items.add(file);
            }
            imagesInput.value='';


            imagesInput.files = dataTransfer.files;
        });

</script>
@endsection
