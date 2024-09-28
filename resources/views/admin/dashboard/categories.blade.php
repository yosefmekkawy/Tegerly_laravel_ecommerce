@extends('layout')
@section('content')

    <div class="container">
        <div class="row">
                @include('components.sidebar')

            <!-- Main Content Area -->
            <div class="col-lg-12">
                <h1 class="text-center mt-2 underline">{{__('pages.categories')}}</h1>
                <div class="row justify-content-between gy-2">
                    <div class="col-md-3">
                        <a href="{{route('categories.create')}}" class="btn btn-primary">{{__('pages.add_category')}}</a>
                    </div>
                    <div class="col-md-4">
                        <form class="align-self-end" method="get" action="{{route('categories.index')}}">
                            <div class="input-group mb-3">
                                <input type="search" class="form-control" placeholder="{{__('pages.search_category')}}" name="name" value="{{old('name')}}">
                                <span class="input-group-text" onclick="this.submit()" style="cursor: pointer" id="basic-addon2"><i class="ri-search-line"></i></span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">

                    @foreach($categories as $category)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 gy-3">
                            <div class="card">
                                <img src="{{asset($category['image']==null ? "images/placeholder.png" :'images/'.$category['image']->name )}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{$category['name']}}</h5>
                                    <div class="category-buttons d-flex justify-content-center gap-3 mt-3">
                                        <a href="{{route('categories.edit',$category['id'])}}" class="btn btn-primary">{{__('pages.edit')}}</a>
                                        <a href="javascript:void(0)" class="btn btn-danger delete" data-id="{{$category['id']}}">{{__('pages.delete')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                {{$object->links()}}
            </div>
        </div>
    </div>

@endsection

@section('styling')
    <link rel="stylesheet" href="{{asset('css/nav.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
    <style>
.card{
    border-radius: 10px;
    padding: 15px;
    border: none;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}

.card{
    height: 350px;
}
.card img{
    width: 100%;
    height: 230px;
    object-fit: contain;
}
.pagination{
    margin-top: 1rem;
}
    </style>
@endsection

@section('scripts')
    <script src="{{asset('js/sidebar.js')}}"></script>
    <script>
        let categories = @json($categories);

        // Now you can use the 'categories' object directly
        console.log(categories);

        document.querySelector('.side-categories').classList.add('active');

        document.querySelectorAll('.delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');

                Swal.fire({
                    title: '{{__('pages.sure_delete')}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor:  '#3085d6',
                    confirmButtonText: '{{__('pages.yes')}}',
                    cancelButtonText:'{{__('pages.no')}}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform the delete action by redirecting to the delete URL
                        window.location.href = `/delete-item?model=categories&id=${categoryId}`;
                    }
                });
            });
        });
    </script>
@endsection
