<x-layout>
    <div class="post-container single-post">
        <div class="post-header">
            <h1 class="text-3xl py-4">Post: {{ $post->created_at }}</h1>
            <div class="post-buttons">
                <a href="{{ route('post.edit', $post) }}" class="post-edit-button">Edit</a>
                <form action="{{ route('post.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="post-delete-button">Delete</button>
                </form>
            </div>
        </div>
        <div class="post">
            <div class="post-body">
                {{ $post->post }}
            </div>
        </div>
    </div></x-layout>
