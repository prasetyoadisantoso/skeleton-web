{{-- Blog Section --}}
<div class="container-fluid h-100 py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @component('template.default.frontend.component.content', [
                'posts' => $posts
                ])

                @endcomponent
            </div>
            <div class="col-md-4">
                @component('template.default.frontend.component.category-tag', [
                'categories' => $categories,
                'tags' => $tags
                ])
                @endcomponent
            </div>
        </div>
    </div>
</div>
