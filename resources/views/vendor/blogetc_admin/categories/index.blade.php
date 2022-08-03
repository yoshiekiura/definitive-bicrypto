@extends('blogetc_admin::layouts.admin_layout')
@section('blog')
    @forelse ($categories as $category)
        <div class="card col-lg-6 col-md-6">
            <div class="card-header card-title"> <a href="{{ $category->url() }}">{{ $category->category_name }}</a></div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ $category->url() }}"><button class="btn btn-outline-secondary btn-sm">
                            View Posts
                        </button></a>
                    <a href="{{ route('admin.blogetc.admin.categories.edit_category', $category->id) }}"><button
                            class="btn btn-primary btn-sm">Edit Category</button></a>
                </div>
            </div>
            <div class="card-footer">
                <form
                    onsubmit="return confirm('Are you sure you want to delete this blog post category?\n You cannot undo this action!');"
                    method="post" action="{{ route('admin.blogetc.admin.categories.destroy_category', $category->id) }}"
                    class="float-right">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm" value="Delete">Delete</button>


                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-danger">None found, why don't you add one?</div>
    @endforelse

    <div class="text-center">
        {{ $categories->links() }}
    </div>
@endsection
